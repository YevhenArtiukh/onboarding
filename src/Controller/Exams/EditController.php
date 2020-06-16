<?php


namespace App\Controller\Exams;


use App\Entity\Exams\Exam;
use App\Entity\Exams\UseCase\EditExam;
use App\Form\Exams\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Exams\UseCase\EditExam\Responder;

class EditController extends AbstractController implements Responder
{
    /**
     * @Route("/exam/{exam}/edit", name="exam_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Exam $exam
     * @param EditExam $editExam
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function index(Request $request, Exam $exam, EditExam $editExam)
    {
        $form = $this->createForm(
            EditType::class,
            $this->transformData($exam),
            [
                'type' => $exam->getType()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditExam\Command(
                $exam,
                (string) $data['name'],
                (string) $data['status'],
                (int) $data['duration']
            );
            $command->setResponder($this);

            $editExam->execute($command);

            return $this->redirectToRoute('training_edit', ['training' => $exam->getTraining()->getId()]);
        }

        return $this->render('exams/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function transformData(Exam $exam)
    {
        return [
          'name' => $exam->getName(),
          'type' => $exam->getType(),
          'duration' => $exam->getDuration(),
          'status' => $exam->getIsActive()
        ];
    }
}