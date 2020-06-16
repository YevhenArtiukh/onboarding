<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:46
 */

namespace App\Controller\Questions;


use App\Entity\Exams\Exam;
use App\Entity\Exams\Exam\Type;
use App\Entity\Questions\UseCase\CreateQuestion;
use App\Entity\Questions\UseCase\CreateQuestion\Responder;
use App\Form\Questions\AddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/exam/{exam}/question/add", name="question_add", methods={"GET", "POST"})
     */
    public function index(Exam $exam, Request $request, CreateQuestion $createQuestion)
    {
        $form = $this->createForm(
            AddType::class,
            [],
            [
                'answersType' => (new Type($exam->getType()))->generateAnswersType()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateQuestion\Command(
                $exam,
                (string)$data['name'],
                (string)$data['type'],
                $data['answers'] ?? null
            );
            $command->setResponder($this);

            $createQuestion->execute($command);
            if($this->container->get('session')->getFlashBag()->has('success'))
            {
                return $this->redirectToRoute('exam_show', ['exam' => $exam->getId()]);
            }
        }

        return $this->render('questions/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function questionCreated()
    {
        $this->addFlash('success', 'Pytanie zostało stworzone');
    }

    public function correctAnswerNotExist()
    {
        $this->addFlash('error', 'Nie zaznaczono żadnej prawidłowej odpowiedzi');
    }
}