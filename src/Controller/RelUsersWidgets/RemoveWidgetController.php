<?php


namespace App\Controller\RelUsersWidgets;


use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\RelUsersWidgets\UseCase\RemoveWidget;
use App\Entity\Widgets\Widget;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RemoveWidgetController extends AbstractController
{
    /**
     * @Route("/widget/{userWidget}/remove", name="remove_widget", methods={"GET"})
     * @throws \Throwable
     */
    public function index( RelUserWidget $userWidget, RemoveWidget $removeWidget)
    {

        $command = new RemoveWidget\Command(
            $userWidget
        );

        $removeWidget->execute($command);

        return $this->redirectToRoute('dashboard');
    }
}