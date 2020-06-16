<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-02
 * Time: 12:16
 */

namespace App\Controller\Reports;


use App\Adapter\Reports\ReadModel\ReportQuery;
use App\Form\Reports\NumberOfParticipants\DateBetweenType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NumberOfParticipantsController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/report/number-of-participants", name="report_number_of_participants", methods={"GET", "POST"})
     * @IsGranted("number_of_participants")
     */
    public function index(Request $request, ReportQuery $reportQuery)
    {
        $formDateBetween = $this->createForm(DateBetweenType::class);

        if($request->isMethod("POST")) {

            return new JsonResponse($reportQuery->numberOfParticipants(
                $request->get('dateStart'),
                $request->get('dateEnd'),
                $request->get('division'),
                $this->getUser()->getDepartment()->getDivision()
            ));
        }

        return $this->render('reports/number_of_participants.html.twig', [
            'formDateBetween' => $formDateBetween->createView()
        ]);
    }
}