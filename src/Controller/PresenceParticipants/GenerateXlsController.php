<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 15:52
 */

namespace App\Controller\PresenceParticipants;


use App\Adapter\OnboardingTrainings\ReadModel\ParticipantsOnboardingTrainingQuery;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\ReadModel\ParticipantsOnboardingTraining;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Writer;

class GenerateXlsController extends AbstractController
{
    /**
     * @Route("/onboarding-training/{onboardingTraining}/participants/generate-xls", name="presence_participants_generate_xls", methods={"POST"})
     */
    public function index(OnboardingTraining $onboardingTraining, ParticipantsOnboardingTrainingQuery $participantsOnboardingTrainingQuery)
    {
        $writer = new Writer\Xls($this->generateSpreadsheet($onboardingTraining, $participantsOnboardingTrainingQuery));

        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');

            }
        );

        $filename = $onboardingTraining->getTraining()->getName().'_lista_'.(new \DateTime())->format('d.m.Y');
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    private function generateSpreadsheet(OnboardingTraining $onboardingTraining, ParticipantsOnboardingTrainingQuery $participantsOnboardingTrainingQuery)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = [
            ['key' => 'A1', 'value' => 'L.p.'],
            ['key' => 'B1', 'value' => 'Imię'],
            ['key' => 'C1', 'value' => 'Nazwisko'],
            ['key' => 'D1', 'value' => 'Obszar'],
            ['key' => 'E1', 'value' => 'Przełożony'],
            ['key' => 'F1', 'value' => 'Data zaliczenia']
        ];
        if($onboardingTraining->isTypePresence()) {
            $header[] = ['key' => 'G1', 'value' => 'Potw. obec. uczestnika'];
            $header[] = ['key' => 'H1', 'value' => 'Potw. obec. trenera'];
        } else {
            $header[] = ['key' => 'G1', 'value' => 'Wynik'];
        }

        foreach ($header as $data) {
            $sheet->setCellValue($data['key'],$data['value']);
        }

        $users = $participantsOnboardingTrainingQuery->findAll($onboardingTraining);

        /**
         * @var ParticipantsOnboardingTraining $user
         */
        foreach ($users as $key => $user) {
            $sheet->setCellValue("A".($key+2), $key+1);
            $sheet->setCellValue("B".($key+2), $user->getName());
            $sheet->setCellValue("C".($key+2), $user->getSurname());
            $sheet->setCellValue("D".($key+2), $user->getDepartment());
            $sheet->setCellValue("E".($key+2), $user->getManagerFullName());
            $sheet->setCellValue("F".($key+2), $user->getDate());

            if($onboardingTraining->isTypePresence()) {
                $sheet->setCellValue("G".($key+2), $user->isUserConfirmation());
                $sheet->setCellValue("H".($key+2), $user->isCoachConfirmation());
            } else {
                $sheet->setCellValue("G".($key+2), $user->getScore());
            }

        }

        $columns = ['A','B','C','D','E','F','G','H'];

        foreach ($columns as $column){
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $spreadsheet;
    }
}