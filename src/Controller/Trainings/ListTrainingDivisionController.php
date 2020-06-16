<?php


namespace App\Controller\Trainings;


use App\Adapter\TrainingDivisions\ReadModel\TrainingDivisionsQuery;
use App\Adapter\Trainings\ReadModel\TrainingQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListTrainingDivisionController extends AbstractController
{
    /**
     * @param TrainingQuery $trainingQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/trainingsDivision", name="trainings_division", methods={"GET"})
     */
    public function index(TrainingDivisionsQuery $trainingDivisionsQuery)
    {

        return $this->render('trainings/list.html.twig', [
            'trainings' => $trainingDivisionsQuery->getByDivision($this->getUser()->getDepartment()->getDivision())
        ]);
    }

}