<?php


namespace App\Controller\Dashboard\DashboardWidgetPages;


use App\Adapter\RelUsersWidgets\ReadModel\RelUserWidgetQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EndangeredDatesByDivisionPartner extends AbstractController
{
    /**
     * @Route("/endangered-dates/division-partner", name="endangered_dates_division", methods={"GET"})
     * @param RelUserWidgetQuery $relUserWidgetQuery
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RelUserWidgetQuery $relUserWidgetQuery)
    {
        return $this->render('dashboard/dashboardWidgetPages/endangered_dates_division.html.twig', [
            'users' => $relUserWidgetQuery->endangeredDatesByDivision($this->getUser())
        ]);
    }
}
