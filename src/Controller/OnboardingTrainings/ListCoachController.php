<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 12:12
 */

namespace App\Controller\OnboardingTrainings;


use App\Adapter\OnboardingTrainings\ReadModel\CoachOnboardingTrainingQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListCoachController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/onboarding-trainings", name="coach_onboarding_trainings", methods={"GET"})
     * @IsGranted("coach_onboarding_trainings")
     */
    public function index(CoachOnboardingTrainingQuery $coachOnboardingTrainingQuery)
    {
        return $this->render('onboarding_trainings/list_coach.html.twig', [
            'onboardingTrainings' => $coachOnboardingTrainingQuery->findAll($this->getUser())
        ]);
    }
}