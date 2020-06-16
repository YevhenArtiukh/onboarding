<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-23
 * Time: 10:56
 */

namespace App\Controller\Users;


use App\Adapter\Users\ReadModel\UserOnboardingTrainingQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserTrainings extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/my-trainings", name="my_trainings", methods={"GET"})
     */
    public function index(UserOnboardingTrainingQuery $userOnboardingTrainingQuery)
    {
        return $this->render('users/my_trainings.html.twig', [
            'userOnboardingTrainings' => $userOnboardingTrainingQuery->findAllForUser($this->getUser())
        ]);
    }
}