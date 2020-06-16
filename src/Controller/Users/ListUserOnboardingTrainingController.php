<?php


namespace App\Controller\Users;


use App\Adapter\Users\ReadModel\UserOnboardingTrainingQuery;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListUserOnboardingTrainingController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/{user}/user-trainings", name="user_onboarding_training", methods={"GET"})
     */
    public function index(User $user, UserOnboardingTrainingQuery $userOnboardingTrainingQuery)
    {
        return $this->render('users/list_onboarding_trainings.html.twig', [
            'userOnboardingTrainings' => $userOnboardingTrainingQuery->findAllForUser($user),
            'user' => $user
        ]);
    }
}