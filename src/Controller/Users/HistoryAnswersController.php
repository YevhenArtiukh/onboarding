<?php


namespace App\Controller\Users;


use App\Adapter\UserAnswers\ReadModel\UserAnswersQuery;
use App\Entity\UserResults\UserResult;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HistoryAnswersController extends AbstractController
{
    /**
     * @Route("/user/{user}/history-exams/{userResult}/history-answer", name="user_history_answer", methods={"GET"})
     * @param User $user
     * @param UserResult $userResult
     * @param UserAnswersQuery $userAnswersQuery
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index( User $user, UserResult $userResult, UserAnswersQuery $userAnswersQuery)
    {

        return $this->render('users/history_answers.html.twig', [
            'userAnswers' => $userAnswersQuery->getAllByUserResult($userResult),
            'trainingName' => $userResult->getOnboardingTraining()->getTraining()->getName()
        ]);
    }
}