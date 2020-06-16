<?php


namespace App\Controller\Dashboard;


use App\Adapter\Dashboard\DashboardQuery;
use App\Adapter\RelUsersWidgets\RelUsersWidgets;
use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\RelUsersWidgets\UseCase\AddUserWidget;
use App\Entity\Users\User;
use App\Form\Dashboard\AddSmallChart;
use App\Form\Dashboard\AddWidgetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     *
     * @Route("/", name="dashboard", methods={"GET|POST"})
     * @IsGranted("dashboard_page")
     * @param Request $request
     * @param RelUsersWidgets $relUsersWidgets
     * @param DashboardQuery $dashboardQuery
     * @param AddUserWidget $addUserWidget
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Throwable
     */
    public function index(Request $request, RelUsersWidgets $relUsersWidgets, DashboardQuery $dashboardQuery, AddUserWidget $addUserWidget)
    {


        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if($currentUser->getCurrentRole()->getName() == "Pracownik" || $currentUser->getCurrentRole()->getName() == "Manager")
            return $this->redirectToRoute('training_schedule_general');

        /** @var RelUserWidget[] $userWidgets */
        $userWidgets = $relUsersWidgets->findAllByUserAndCurrentRole($currentUser);

        $widgetsAfterTransform = $this->transformUserWidgetToWidgetArray($userWidgets);


        $form = $this->createForm(AddWidgetType::class, null, [
            'roleID' => $currentUser->getCurrentRole()->getId(),
            'widgets' => $widgetsAfterTransform
        ]);
        $form->handleRequest($request);

        $formSmallChart = $this->createForm(AddSmallChart::class, null, [
            'roleID' => $currentUser->getCurrentRole()->getId(),
            'chart' => "S",
            'widgets' => $widgetsAfterTransform
        ]);
        $formSmallChart->handleRequest($request);


        if (($form->isSubmitted() && $form->isValid())
            ||
            ($formSmallChart->isSubmitted() && $formSmallChart->isValid())) {
            $data = $form->getData() ? $form->getData() : $formSmallChart->getData();

            $command = new AddUserWidget\Command(
                $currentUser,
                $data['widget'],
                (int)$data['position']
            );

            $addUserWidget->execute($command);

            return $this->redirectToRoute('dashboard');
        }


        foreach ($userWidgets as $userWidget) {
            if ($userWidget->getWidgetID()->getChart() == 'S')
                $userWidget->getWidgetID()->setChartData($dashboardQuery->valueByWidgetQuery($userWidget->getWidgetID()->getQuery(), $currentUser));
            else
                $userWidget->getWidgetID()->setValue($dashboardQuery->valueByWidgetQuery($userWidget->getWidgetID()->getQuery(), $currentUser));
        }


        return $this->render('dashboard/dashboard.html.twig', [
            'form' => $form->createView(),
            'formSmallChart' => $formSmallChart->createView(),
            'UW' => $this->userWidgetToArray($userWidgets),
        ]);
    }

    private function userWidgetToArray(array $userWidgets)
    {
        $arrUserWidgetsValue = [
            'position' => [],
            'widget' => [],
        ];
        /** @var RelUserWidget $uW */
        foreach ($userWidgets as $key => $uW) {
            $arrUserWidgetsValue['position'][] = $uW->getPosition();
            $arrUserWidgetsValue['widget'][$uW->getPosition()] = $uW;
        }

        return $arrUserWidgetsValue;
    }

    private function transformUserWidgetToWidgetArray(array $userWidgets)
    {
        $result = [];
        /** @var RelUserWidget[] $userWidgets */
        foreach ($userWidgets as $userWidget) {
            $result[]  = $userWidget->getWidgetID()->getId();
        }
        return $result;
    }

}