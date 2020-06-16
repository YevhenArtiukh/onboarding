<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:20
 */

namespace App\Controller\Trainings;


use App\Adapter\Exams\ReadModel\ExamQuery;
use App\Adapter\Trainings\UploadedImage;
use App\Entity\Exams\UseCase\CreateExam;
use App\Entity\TrainingAttachments\UseCase\AddTrainingAttachment;
use App\Entity\TrainingAttachments\UseCase\AddTrainingAttachment\Responder as AddAttachResponder;
use App\Entity\Trainings\Training;
use App\Entity\Trainings\UseCase\EditTraining;
use App\Entity\Trainings\UseCase\EditTraining\Responder;
use App\Entity\Exams\UseCase\CreateExam\Responder as AddExamResponder;
use App\Form\Exams\AddType as AddExamType;
use App\Form\TrainingAttachments\AddType as AddAttachmentType;
use App\Form\Trainings\EditType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder, AddExamResponder, AddAttachResponder
{
    /**
     * @param Request $request
     * @param Training $training
     * @param EditTraining $editTraining
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/training/{training}/edit", name="training_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, Training $training, EditTraining $editTraining, CreateExam $createExam, AddTrainingAttachment $addTrainingAttachment, ExamQuery $examQuery)
    {

        $form = $this->createForm(
            EditType::class,
            $this->transformData($training),
            [
                'kindOfTraining' => $training->getKindOfTraining()
            ]
        );
        $form->handleRequest($request);

        $formExam = $this->createForm(
            AddExamType::class
        );
        $formExam->handleRequest($request);

        $formAttachment = $this->createForm(
            AddAttachmentType::class
        );
        $formAttachment->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditTraining\Command(
                $training,
                (string)$data['name'],
                (int)$data['time'],
                (string)$data['typeOfTraining'],
                (string)$data['kindOfTraining'],
                $data['description'],
                $data['trainerInfo'],
                $data['workerInfo'],
                isset($data['additionalTraining']) ? $data['additionalTraining'] : false,
                ($data['kindOfTraining'] === Training\KindOfTraining::KIND_OF_TRAINING_DIVISIONS) ? $data['division'] : new ArrayCollection(),
                $data['image'] ? new UploadedImage(
                    $data['image'],
                    $this->getParameter('training_photo_dir')
                ) : null
            );
            $command->setResponder($this);

            $editTraining->execute($command);

            return $this->redirectToRoute('trainings');
        }


        if ($formAttachment->isSubmitted() && $formAttachment->isValid()) {
            $data = $formAttachment->getData();

            $command = new AddTrainingAttachment\Command(

                $training,
                $data['file']->getClientOriginalName(),
                 new UploadedImage(
                    $data['file'],
                    $this->getParameter('training_attachment_dir')
                )
            );

            $command->setResponder($this);

            $addTrainingAttachment->execute($command);

            return $this->redirectToRoute('training_edit', ['training' => $training->getId()]);
        }
        if ($formExam->isSubmitted() && $formExam->isValid()) {
            $data = $formExam->getData();

            $command = new CreateExam\Command(
                (string)$data['name'],
                (string)$data['type'],
                (int)$data['duration'],
                (bool)$data['status'],
                $training
            );
            $command->setResponder($this);

            $createExam->execute($command);

            return $this->redirectToRoute('training_edit', ['training' => $training->getId()]);
        }
        return $this->render('trainings/edit.html.twig', [
            'form' => $form->createView(),
            'formExam' => $formExam->createView(),
            'formAttach' => $formAttachment->createView(),
            'exams' => $examQuery->getAllByTraining($training),
            'trainingAttachments' => $training->getTrainingAttachments()
        ]);
    }

    private function transformData(Training $training)
    {
        return [
            'name' => $training->getName(),
            'time' => $training->getTime(),
            'typeOfTraining' => $training->getTypeOfTraining(),
            'kindOfTraining' => $training->getKindOfTraining(),
            'description' => $training->getDescription(),
            'trainerInfo' => $training->getTrainerInfo(),
            'workerInfo' => $training->getWorkerInfo(),
            'division' => $training->getDivisions(),
            'additionalTraining' => $training->getIsAdditional(),
            'image' => $training->getImage() ? new File(
                $this->getParameter('training_photo_dir') . DIRECTORY_SEPARATOR . $training->getImage()
            ) : null
        ];
    }
}
