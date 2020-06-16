<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-02
 * Time: 14:49
 */

namespace App\Controller\Reports;


use App\Adapter\Reports\ReadModel\ReportQuery;
use App\Entity\Divisions\Division;
use App\Entity\Exams\Exam\Type;
use App\Form\Reports\EvaluationSurvey\EvaluationSurveyExport;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer;

class EvaluationSurveyExportController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/report/evaluation-survey-export", name="report_evaluation_survey_export", methods={"GET", "POST"})
     * @IsGranted("evaluation_survey")
     */
    public function index(Request $request, ReportQuery $reportQuery)
    {
        $form = $this->createForm(EvaluationSurveyExport::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $dateStart = $data['dateStart']->getDateStart()->format('d.m.Y');
            $dateEnd = $data['dateEnd']->getDateStart()->format('d.m.Y');

            $writer = new Writer\Xls($this->generateSpreadsheet(
                $reportQuery,
                $dateStart,
                $dateEnd,
                $this->getUser()->getDepartment()->getDivision()
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

        return $this->render('reports/evaluation_survey_export.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function generateSpreadsheet(ReportQuery $reportQuery, string $dateStart, string $dateEnd, Division $division)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $data = $reportQuery->evaluationSurveyExport(
            $dateStart,
            $dateEnd,
            $division
        );

        $questions = [];
        $columnIndex = 0;
        $rowIndex = 1;
        $userResultId = null;
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

        /**
         * @var \App\Entity\Reports\ReadModel\EvaluationSurveyExport $evaluationSurvayExport
         */
        foreach ($data as $evaluationSurvayExport) {
            if (!in_array($evaluationSurvayExport->getQuestion(), $questions)) {
                $questions[] = $evaluationSurvayExport->getQuestion();
                $answerColumn = $columns[$columnIndex];
                $sheet->setCellValue($columns[$columnIndex] . "1", $evaluationSurvayExport->getQuestion());
                $columnIndex++;
            } else {
                $answerColumn = $columns[array_search($evaluationSurvayExport->getQuestion(), $questions)];
            }


            if ($userResultId !== $evaluationSurvayExport->getUserResultId()) {
                $userResultId = $evaluationSurvayExport->getUserResultId();
                $rowIndex++;
            }

            $sheet->setCellValue($answerColumn . $rowIndex, $evaluationSurvayExport->getAnswerValue());
        }

        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $spreadsheet;
    }
}