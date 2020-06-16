<?php


namespace App\Controller\Questions;


use App\Entity\Exams\Exam;
use App\Entity\Exams\UseCase\DeleteExam;
use App\Entity\Questions\Question;
use App\Entity\Questions\UseCase\DeleteQuestion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Questions\UseCase\DeleteQuestion\Responder;

class DeleteQuestionController extends AbstractController implements Responder
{
    /**
     * @Route("/question/{question}/delete", name="question_delete", methods={"DELETE"})
     */
    public function index(Request $request, Question $question, DeleteQuestion $deleteQuestion)
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $command = new DeleteQuestion\Command(
                $question
            );
            $command->setResponder($this);

            $deleteQuestion->execute($command);

            return new JsonResponse('success');
        }
        return new JsonResponse('Csrf token is not Valid', 400);

    }

    public function questionDeleted()
    {
        $this->addFlash('success', 'Pytanie zostało usunięte');
    }
}