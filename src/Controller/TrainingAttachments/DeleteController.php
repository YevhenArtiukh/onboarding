<?php


namespace App\Controller\TrainingAttachments;


use App\Entity\TrainingAttachments\TrainingAttachment;
use App\Entity\TrainingAttachments\UseCase\DeleteTrainingAttachment;
use App\Entity\TrainingAttachments\UseCase\DeleteTrainingAttachment\Responder;
use App\Entity\Trainings\Training;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class DeleteController extends AbstractController implements Responder
{

    /**
     * @Route("attachment/{trainingAttachment}/delete", name="training_attachment_delete", methods={"DELETE"})
     * @param Request $request
     * @param TrainingAttachment $trainingAttachment
     * @param DeleteTrainingAttachment $deleteTrainingAttachment
     * @return JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request, TrainingAttachment $trainingAttachment, DeleteTrainingAttachment $deleteTrainingAttachment)
    {
        if ($this->isCsrfTokenValid('delete'.$trainingAttachment->getId(), $request->request->get('_token'))) {
            $command = new DeleteTrainingAttachment\Command(
                $trainingAttachment
            );
            $command->setResponder($this);

            $deleteTrainingAttachment->execute($command);

            return new JsonResponse('success');
        }
        return new JsonResponse('Csrf token is not Valid', 400);
    }

    public function trainingAttachmentDeleted()
    {
        $this->addFlash('success', 'Materiał szkoleniowy został usunięty');
    }
}