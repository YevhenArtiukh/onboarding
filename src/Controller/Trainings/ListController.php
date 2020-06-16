<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:20
 */

namespace App\Controller\Trainings;


use App\Adapter\Trainings\ReadModel\TrainingQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param TrainingQuery $trainingQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/trainings", name="trainings", methods={"GET"})
     */
    public function index(TrainingQuery $trainingQuery)
    {
        return $this->render('trainings/list.html.twig', [
            'trainings' => $trainingQuery->getGeneral()
        ]);
    }
}