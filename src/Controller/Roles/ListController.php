<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:40
 */

namespace App\Controller\Roles;


use App\Adapter\Roles\ReadModel\RoleQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param RoleQuery $roleQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/roles", name="roles", methods={"GET"})
     * @IsGranted("roles")
     */
    public function index(RoleQuery $roleQuery)
    {
        return $this->render('roles/list.html.twig', [
            'roles' => $roleQuery->findAll()
        ]);
    }
}