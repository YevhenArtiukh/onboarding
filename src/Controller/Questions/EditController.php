<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-06
 * Time: 12:16
 */

namespace App\Controller\Questions;


use App\Entity\Exams\Exam;
use App\Entity\Exams\Exam\Type;
use App\Entity\Questions\Question;
use App\Entity\Questions\UseCase\EditQuestion;
use App\Entity\Questions\UseCase\EditQuestion\Responder;
use App\Form\Questions\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/exam/{exam}/question/{question}/edit", name="question_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, Exam $exam, Question $question, EditQuestion $editQuestion)
    {
        $form = $this->createForm(
            EditType::class,
            $this->transformData($question),
            [
                'answersType' => (new Type($exam->getType()))->generateAnswersType()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditQuestion\Command(
                (int) $question->getId(),
                (string) $data["name"],
                (string) $data["type"],
                $data["answers"]??null
            );
            $command->setResponder($this);

            $editQuestion->execute($command);

            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('exam_show', ['exam'=>$exam->getId()]);
        }

        return $this->render('questions/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function transformData(Question $question)
    {
        foreach ($question->getAnswers() as $answer) {
            $answers[] = [
                'answer' => $answer->getName(),
                'correct' => $answer->getCorrect()
            ];
        }

        return [
            'name' => $question->getName(),
            'type' => $question->getType(),
            'answers' => $answers??null
        ];
    }

    public function questionNotFound()
    {
        $this->addFlash('error', 'Podane pytanie nie istnieje');
    }

    public function questionEdited()
    {
        $this->addFlash('success', 'Pytanie zostało zmienione');
    }
}