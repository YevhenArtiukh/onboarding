<?php


namespace App\Controller\Dashboard\DashboardWidgetPages;


use App\Adapter\RelUsersWidgets\ReadModel\RelUserWidgetQuery;
use App\Adapter\Users\ReadModel\UserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EndangeredDatesByCoach extends AbstractController
{
    /**
     * @Route("/endangered-dates/coach", name="endangered_dates_coach", methods={"GET"})
     * @param RelUserWidgetQuery $relUserWidgetQuery
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RelUserWidgetQuery $relUserWidgetQuery)
    {
        return $this->render('dashboard/dashboardWidgetPages/endangered_dates_coach.html.twig', [
            'users' => $relUserWidgetQuery->endangeredDatesByCoach($this->getUser())
        ]);
    }
}