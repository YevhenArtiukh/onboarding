<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-02
 * Time: 14:48
 */

namespace App\Controller\Reports;


use App\Adapter\Reports\ReadModel\ReportQuery;
use App\Form\Reports\EvaluationSurvey\EvaluationSurveyChart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EvaluationSurveyChartController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/report/evaluation-survey-chart", name="report_evaluation_survey_chart", methods={"GET", "POST"})
     * @IsGranted("evaluation_survey")
     */
    public function index(Request $request, ReportQuery $reportQuery)
    {
        $form = $this->createForm(EvaluationSurveyChart::class);
        $form->handleRequest($request);

        if ($request->isMethod("POST") && $request->request->has('question')) {

            return new JsonResponse($reportQuery->evaluationSurveyChart(
                $request->get('onboarding'),
                $request->get('question'),
                $this->getUser()->getDepartment()->getDivision()
            ));
        }

        return $this->render('reports/evaluation_survey_chart.html.twig', [
            'form' => $form->createView()
        ]);
    }
}