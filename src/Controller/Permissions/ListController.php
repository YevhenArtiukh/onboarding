<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:59
 */

namespace App\Controller\Permissions;


use App\Adapter\Permissions\ReadModel\PermissionQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param PermissionQuery $permissionQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/permissions", name="permissions", methods={"GET"})
     * @IsGranted("permissions")
     */
    public function index(PermissionQuery $permissionQuery)
    {
        return $this->render('permissions/list.html.twig', [
            'permissions' => $permissionQuery->findAll()
        ]);
    }
}