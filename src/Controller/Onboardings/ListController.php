<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 14:25
 */

namespace App\Controller\Onboardings;


use App\Adapter\Onboardings\ReadModel\OnboardingQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param OnboardingQuery $onboardingQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/onboardings", name="onboardings", methods={"GET"})
     */
    public function index(OnboardingQuery $onboardingQuery)
    {
        return $this->render('onboardings/list.html.twig', [
            'onboardings' => $onboardingQuery->findAll()
        ]);
    }
}