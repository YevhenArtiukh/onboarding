<?php


namespace App\Controller\Exams;


use App\Entity\Exams\Exam;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\UserResults\UseCase\CreateUserResult;
use App\Entity\UserResults\UseCase\CreateUserResultQuestionnaire;
use App\Form\Exams\QuestionnaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserResults\UseCase\CreateUserResultQuestionnaire\Responder as CreateUserResultQuestionnaireResponder;

class QuestionnaireController extends AbstractController implements CreateUserResultQuestionnaireResponder
{
    /**
     * @param Request $request
     * @param OnboardingTraining $onboardingTraining
     * @param Exam $exam
     * @param CreateUserResultQuestionnaire $createUserResultQuestionnaire
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding-training/{onboardingTraining}/exam/{exam}/questionnaire", name="questionnaire", methods={"GET", "POST"})
     */
    public function index(Request $request, OnboardingTraining $onboardingTraining, Exam $exam, CreateUserResultQuestionnaire $createUserResultQuestionnaire)
    {
        $form = $this->createForm(
            QuestionnaireType::class,
            [],
            [
                'questions' => $exam->getQuestions()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $command = new CreateUserResultQuestionnaire\Command(
                $this->getUser(),
                $exam,
                $onboardingTraining,
                $data
            );
            $command->setResponder($this);

            $createUserResultQuestionnaire->execute($command);

            return $this->redirectToRoute('my_trainings');
        }

        return $this->render('exams/questionnaire.html.twig',
        [
            'form' => $form->createView()
        ]);
    }

    public function userResultQuestionnaireCreated()
    {
       $this->addFlash('success', 'Ankieta zakończona sukcesem');
    }
}