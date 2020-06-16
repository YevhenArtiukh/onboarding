<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-22
 * Time: 14:59
 */

namespace App\Controller\Departments;


use App\Adapter\Departments\ReadModel\BusinessPartnerQuery;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowBusinessPartnerController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/business-partner/{user}", name="business_partner", methods={"GET"}, defaults={"user"=null})
     */
    public function index(Request $request, ?User $user, BusinessPartnerQuery $businessPartnerQuery)
    {
        return $this->render('departments/show_business_partner.html.twig',[
            'departments' => $businessPartnerQuery->findByIdBusinessPartner($user,$this->getUser()->getDepartment()->getDivision())
        ]);
    }
}