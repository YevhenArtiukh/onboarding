<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 10:59
 */

namespace App\Controller\Users;


use App\Adapter\Users\ReadModel\UserQuery;
use App\Adapter\Users\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param UserQuery $userQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/users", name="users", methods={"GET"})
     * @IsGranted("users")
     */
    public function index(UserQuery $userQuery)
    {
        return $this->render('users/list.html.twig', [
            'users' => $userQuery->findAll($this->getUser())
        ]);
    }
}