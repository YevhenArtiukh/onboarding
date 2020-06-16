<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-28
 * Time: 12:01
 */

namespace App\Controller\Reports;


use App\Adapter\Reports\ReadModel\ReportQuery;
use App\Entity\Departments\Department;
use App\Entity\Reports\ReadModel\ExportDataDateBetween;
use App\Entity\Reports\ReadModel\ExportDataUserSearch;
use App\Entity\Users\User;
use App\Form\Reports\ExportData\DateBetweenType;
use App\Form\Reports\ExportData\UserSearchType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExportDataController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/report/export-data", name="report_export_data", methods={"GET", "POST"})
     */
    public function index(Request $request, ReportQuery $reportQuery)
    {
        if (!in_array($this->getUser()->getCurrentRole()->getName(), ['Manager', 'P&O BP']))
            throw $this->createNotFoundException();

        $formDateBetween = $this->createForm(DateBetweenType::class);
        $formDateBetween->handleRequest($request);

        if ($formDateBetween->isSubmitted() && $formDateBetween->isValid()) {
            $data = $formDateBetween->getData();

            $dateStart = $data['dateStart']->getDateStart()->format('d.m.Y');
            $dateEnd = $data['dateEnd']->getDateStart()->format('d.m.Y');
            $writer = new Writer\Xls($this->generateSpreadsheetDateBetween(
                $reportQuery,
                $dateStart,
                $dateEnd
            ));

            $response = new StreamedResponse(
                function () use ($writer) {
                    $writer->save('php://output');
                }
            );

            $filename = 'Eksport pracowników ' . $dateStart . ' - ' . $dateEnd;
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '.xls"');
            $response->headers->set('Cache-Control', 'max-age=0');
            return $response;
        }

        $formUserSearch = $this->createForm(
            UserSearchType::class,
            [
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
                'department' => $request->get('department')?$this->getDoctrine()->getRepository(Department::class)->findOneBy(['id'=>$request->get('department')]):null
            ],
            [
                'user' => $this->getUser()
            ]
        );
        $formUserSearch->handleRequest($request);

        if ($formUserSearch->isSubmitted() && $formUserSearch->isValid()) {
            $data = $formUserSearch->getData();

            return $this->redirectToRoute('report_export_data', [
                'name' => $data['name'],
                'surname' => $data['surname'],
                'department' => $data['department'] ? $data['department']->getId() : null
            ]);
        }

        if ($request->get('surname')) {
            $usersSearch = $reportQuery->exportDataUserSearch(
                $this->getUser(),
                $request->get('name'),
                $request->get('surname'),
                $request->get('department')
            );

            $users = [];

            /**
             * @var ExportDataUserSearch $user
             */
            foreach ($usersSearch as $user) {
                $data = [
                    'id' => $user->getUserId(),
                    'fullname' => $user->getUserName() . ' ' . $user->getUserSurname(),
                    'login' => $user->getUserLogin(),
                    'department' => $user->getDepartment()
                ];

                if (!in_array($data, $users))
                    $users[] = $data;
            }
        }

        return $this->render('reports/export_data.html.twig', [
            'formDateBetween' => $formDateBetween->createView(),
            'formUserSearch' => $formUserSearch->createView(),
            'users' => $users ?? null
        ]);
    }

    /**
     * @return StreamedResponse
     * @Route("/report/export-data/{user}", name="report_export_data_user")
     */
    public function userSearch(User $user, ReportQuery $reportQuery)
    {
        if (!in_array($this->getUser()->getCurrentRole()->getName(), ['Manager', 'P&O BP']))
            throw $this->createNotFoundException();

        $writer = new Writer\Xls($this->generateSpreadsheetSearchUser(
            $reportQuery,
            $user->getId()
        ));

        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );

        $filename = 'Eksport_' . $user->getName() . '_' . $user->getSurname() . '_' . (new \DateTime())->format('d.m.Y');
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    private function generateSpreadsheetDateBetween(ReportQuery $reportQuery, string $dateStart, string $dateEnd)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = [
            ['key' => 'A7', 'value' => 'L.p.'],
            ['key' => 'B7', 'value' => 'Imię'],
            ['key' => 'C7', 'value' => 'Nazwisko'],
            ['key' => 'D7', 'value' => 'Przełożony'],
            ['key' => 'E7', 'value' => 'P&O BP'],
            ['key' => 'F7', 'value' => 'Dywizja'],
            ['key' => 'G7', 'value' => 'Obszar'],
            ['key' => 'H7', 'value' => 'Obszar nadrzędny'],
            ['key' => 'I7', 'value' => 'Onboarding'],
            ['key' => 'J7', 'value' => 'Nazwa szkolenia'],
            ['key' => 'K7', 'value' => 'Wynik szkolenia'],
            ['key' => 'L7', 'value' => 'Data oceny'],
            ['key' => 'M7', 'value' => 'Próba'],
            ['key' => 'N7', 'value' => 'Status użytkownika']
        ];

        foreach ($header as $data) {
            $sheet->setCellValue($data['key'], $data['value']);
        }

        $users = $reportQuery->exportDataDateBetween(
            $this->getUser(),
            $dateStart,
            $dateEnd
        );

        $onboardings = $employees = [];

        /**
         * @var ExportDataDateBetween $user
         */
        foreach ($users as $key => $user) {
            $sheet->setCellValue("A" . ($key + 8), $key + 1);
            $sheet->setCellValue("B" . ($key + 8), $user->getUserName());
            $sheet->setCellValue("C" . ($key + 8), $user->getUserSurname());
            $sheet->setCellValue("D" . ($key + 8), $user->getManagerSurname() . ' ' . $user->getManagerName());
            $sheet->setCellValue("E" . ($key + 8), $user->getBusinessPartnerSurname() . ' ' . $user->getBusinessPartnerName());
            $sheet->setCellValue("F" . ($key + 8), $user->getDivision());
            $sheet->setCellValue("G" . ($key + 8), $user->getDepartment());
            $sheet->setCellValue("H" . ($key + 8), $user->getParentDepartment());
            $sheet->setCellValue("I" . ($key + 8), $user->getOnboardingDay()->format('d.m.Y'));
            $sheet->setCellValue("J" . ($key + 8), $user->getTraining());
            $sheet->setCellValue("K" . ($key + 8), $user->getScore());
            $sheet->setCellValue("L" . ($key + 8), $user->getDate() ? $user->getDate()->format('d.m.Y') : null);
            $sheet->setCellValue("M" . ($key + 8), $user->getDate() ? $user->getTry() : null);
            $sheet->setCellValue("N" . ($key + 8), $user->getUserStatus());

            $onboardings[] = $user->getOnboardingId();
            $employees[] = $user->getUserId();
        }

        $sheet->setCellValue("D2", 'data od');
        $sheet->setCellValue("E2", $dateStart);
        $sheet->setCellValue("D3", 'data do');
        $sheet->setCellValue("E3", $dateEnd);
        $sheet->setCellValue("D4", 'liczba onboardingów');
        $sheet->setCellValue("E4", count(array_unique($onboardings)));
        $sheet->setCellValue("D5", 'liczba uczestników total');
        $sheet->setCellValue("E5", count(array_unique($employees)));

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    private function generateSpreadsheetSearchUser(ReportQuery $reportQuery, int $userId)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $users = $reportQuery->exportDataUserSearch(
            $this->getUser(),
            null,
            '',
            null,
            $userId
        );

        $first = reset($users);

        if($first) {
            $header = [
                ['key' => 'A8', 'value' => 'Onboarding (data start)'],
                ['key' => 'B8', 'value' => 'Nazwa szkolenia'],
                ['key' => 'C8', 'value' => 'wynik szkolenia'],
                ['key' => 'D8', 'value' => 'data oceny'],
                ['key' => 'E8', 'value' => 'próba']
            ];

            foreach ($header as $data) {
                $sheet->setCellValue($data['key'], $data['value']);
            }

            /**
             * @var ExportDataUserSearch $user
             */
            foreach ($users as $key => $user) {
                $sheet->setCellValue("A" . ($key + 9), $user->getOnboardingDay() ? $user->getOnboardingDay()->format('d.m.Y') : null);
                $sheet->setCellValue("B" . ($key + 9), $user->getTraining());
                $sheet->setCellValue("C" . ($key + 9), $user->getScore());
                $sheet->setCellValue("D" . ($key + 9), $user->getDate() ? $user->getDate()->format('d.m.Y') : null);
                $sheet->setCellValue("E" . ($key + 9), $user->getDate() ? $user->getTry() : null);
            }

            $sheet->setCellValue("B2", 'Imię');
            $sheet->setCellValue("B3", 'Nazwisko');
            $sheet->setCellValue("B4", 'Manager');
            $sheet->setCellValue("B5", 'P&O BP');
            $sheet->setCellValue("B6", 'Obszar');
            $sheet->setCellValue("C2", $first->getUserName());
            $sheet->setCellValue("C3", $first->getUserSurname());
            $sheet->setCellValue("C4", $first->getManagerName() . ' ' . $first->getManagerSurname());
            $sheet->setCellValue("C5", $first->getBusinessPartnerName() . ' ' . $first->getBusinessPartnerSurname());
            $sheet->setCellValue("C6", $first->getDepartment());

            $columns = ['A', 'B', 'C', 'D', 'E'];

            foreach ($columns as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
        }

        return $spreadsheet;
    }
}