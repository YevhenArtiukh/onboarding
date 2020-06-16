<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-22
 * Time: 16:43
 */

namespace App\Controller\Users;


use App\Entity\Onboardings\Onboarding;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrainingScheduleGeneralController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/schedule-general", name="training_schedule_general", methods={"GET"})
     */
    public function index()
    {
        return $this->render('users/training_schedule_general.html.twig', [
            'onboarding' => $this->getDoctrine()->getRepository(Onboarding::class)->trainingScheduleGeneral()
        ]);
    }
}