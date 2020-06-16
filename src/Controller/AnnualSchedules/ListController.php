<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-13
 * Time: 15:22
 */

namespace App\Controller\AnnualSchedules;


use App\Adapter\AnnualSchedules\ReadModel\AnnualScheduleQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/annual-schedules/{year}", name="annual_schedules", methods={"GET"}, defaults={"year"=null})
     * @IsGranted("annual_schedules_list")
     */
    public function index(Request $request, AnnualScheduleQuery $annualScheduleQuery)
    {
        return $this->render('annual_schedules/list.html.twig', [
            'years' => $annualScheduleQuery->getListYear(),
            'annualSchedules' => $annualScheduleQuery->findAll($request->get('year')??(new \DateTime())->format('Y'))
        ]);
    }
}