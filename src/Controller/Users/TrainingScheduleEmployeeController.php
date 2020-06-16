<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-22
 * Time: 16:42
 */

namespace App\Controller\Users;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrainingScheduleEmployeeController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/schedule-employee", name="training_schedule_employee", methods={"GET"})
     */
    public function index()
    {
        return $this->render('users/training_schedule_employee.html.twig', [
            'onboarding' => $this->getUser()->getOnboarding()
        ]);
    }
}