<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-22
 * Time: 13:42
 */

namespace App\Controller\Departments;


use App\Adapter\Departments\ReadModel\BusinessPartnerQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListBusinessPartnerController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/business-partners", name="business_partners", methods={"GET"})
     */
    public function index(Request $request, BusinessPartnerQuery $businessPartnerQuery)
    {
        return $this->render('departments/list_business_partner.html.twig', [
            'businessPartners' => $businessPartnerQuery->findAll($this->getUser()->getDepartment()->getDivision())
        ]);
    }
}