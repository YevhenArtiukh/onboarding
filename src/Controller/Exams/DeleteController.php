<?php


namespace App\Controller\Exams;


use App\Entity\Exams\Exam;
use App\Entity\Exams\UseCase\DeleteExam;
use App\Entity\Exams\UseCase\DeleteExam\Responder;
use App\Entity\Trainings\Training;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController implements Responder
{
    /**
     * @Route("/exam/{exam}/delete", name="exam_delete", methods={"DELETE"})
     * @param Request $request
     * @param Exam $exam
     * @param Training $training
     * @param DeleteExam $deleteExam
     * @return JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request, Exam $exam, DeleteExam $deleteExam)
    {
        if ($this->isCsrfTokenValid('delete'.$exam->getId(), $request->request->get('_token'))) {
            $command = new DeleteExam\Command(
                $exam
            );
            $command->setResponder($this);

            $deleteExam->execute($command);

            return new JsonResponse('success');
        }
        return new JsonResponse('Csrf token is not Valid', 400);

    }

    public function examDeleted()
    {
        $this->addFlash('success', 'Test/ankieta został/a usunięty/a');
    }
}