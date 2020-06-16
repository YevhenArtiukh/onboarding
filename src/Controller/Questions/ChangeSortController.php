<?php


namespace App\Controller\Questions;


use App\Entity\Questions\UseCase\ChangeSortQuestion\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Questions\UseCase\ChangeSortQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChangeSortController extends AbstractController implements Responder
{
    /**
     * @Route("/change/sort/question", name="change_sort_question", methods={"POST"})
     * @param Request $request
     * @param ChangeSortQuestion $changeSortQuestion
     * @throws \Throwable
     */
    public function index(Request $request, ChangeSortQuestion $changeSortQuestion)
    {
        $currentQuestionID = $request->request->get('current');
        $toChangeQuestionID = $request->request->get('toChange');

        $command = new ChangeSortQuestion\Command(
            (int)$currentQuestionID,
            (int)$toChangeQuestionID
        );
        $command->setResponder($this);

        return $changeSortQuestion->execute($command);
    }
}