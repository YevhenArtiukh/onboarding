<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-23
 * Time: 15:34
 */

namespace App\Controller\Exams;


use App\Entity\Exams\Exam;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\UserResults\UseCase\CreateUserResult;
use App\Entity\UserResults\UseCase\CreateUserResult\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WriteController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param OnboardingTraining $onboardingTraining
     * @param Exam $exam
     * @param CreateUserResult $createUserResult
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding-training/{onboardingTraining}/exam/{exam}/write", name="exam_write", methods={"GET", "POST"})
     */
    public function index(Request $request, OnboardingTraining $onboardingTraining, Exam $exam, CreateUserResult $createUserResult)
    {
        if($onboardingTraining->getTraining() !== $exam->getTraining() || !in_array($this->getUser(), $onboardingTraining->getUsers()->toArray()))
            throw $this->createNotFoundException();

        foreach ($onboardingTraining->getUserResults() as $userResult) {
            if($userResult->getUser() === $this->getUser() && $userResult->getScore() === 100)
                throw $this->createNotFoundException();
        }

        if ($request->isMethod("POST")) {
            parse_str($request->get('formData'), $answers);

            $command = new CreateUserResult\Command(
                $onboardingTraining,
                $exam,
                $this->getUser(),
                $answers
            );
            $command->setResponder($this);

            return $createUserResult->execute($command);
        }

        return $this->render('exams/write.html.twig');
    }
}