<?php


namespace App\Controller\Users;

use App\Adapter\UserResults\ReadModel\UserResultsQuery;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryExamsController extends AbstractController
{
    /**
     * @param User $user
     * @param UserResultsQuery $userResultsQuery
     * @return Response
     * @Route("/user/{user}/history-exams", name="user_history_exams", methods={"GET"})
     */
    public function index(User $user, UserResultsQuery $userResultsQuery)
    {
        return $this->render('users/history_exams.html.twig', [
            'userResults' => $userResultsQuery->getAllByUser($user)
        ]);
    }
}