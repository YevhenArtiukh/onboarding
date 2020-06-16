<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-23
 * Time: 13:46
 */

namespace App\Controller\OnboardingTrainings;

use App\Adapter\OnboardingTrainings\ReadModel\ParticipantsOnboardingTrainingQuery;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/onboarding-training/{onboardingTraining}", name="onboarding_training_show", methods={"GET"})
     */
    public function index(OnboardingTraining $onboardingTraining, ParticipantsOnboardingTrainingQuery $participantsOnboardingTrainingQuery)
    {
        return $this->render('onboarding_trainings/show.html.twig', [
            'users' => $participantsOnboardingTrainingQuery->findAll($onboardingTraining)
        ]);
    }
}