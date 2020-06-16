<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:36
 */

namespace App\Controller\Exams;


use App\Adapter\Questions\ReadModel\QuestionQuery;
use App\Entity\Exams\Exam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/exam/{exam}", name="exam_show", methods={"GET"})
     */
    public function index(Exam $exam, QuestionQuery $questionQuery)
    {
        return $this->render('exams/show.html.twig', [
            'questions' => $questionQuery->findAllForExam($exam)
        ]);
    }
}