<?php


namespace App\Entity\UserResults\UseCase\CreateUserResultQuestionnaire;


use App\Entity\Exams\Exam;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $user;
    private $exam;
    private $onboardingTraining;
    private $answers;
    private $responder;


    public function __construct(
        User $user,
        Exam $exam,
        OnboardingTraining $onboardingTraining,

        array $answers)
    {
        $this->user = $user;
        $this->exam = $exam;
        $this->onboardingTraining = $onboardingTraining;
        $this->answers = $answers;
        $this->responder = new NullResponder();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Exam
     */
    public function getExam(): Exam
    {
        return $this->exam;
    }

    /**
     * @return OnboardingTraining
     */
    public function getOnboardingTraining(): OnboardingTraining
    {
        return $this->onboardingTraining;
    }

    /**
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @return Responder
     */
    public function getResponder(): Responder
    {
        return $this->responder;
    }

    /**
     * @param Responder $responder
     */
    public function setResponder(Responder $responder): void
    {
        $this->responder = $responder;
    }


}