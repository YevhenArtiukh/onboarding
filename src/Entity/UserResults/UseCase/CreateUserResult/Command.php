<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-24
 * Time: 12:12
 */

namespace App\Entity\UserResults\UseCase\CreateUserResult;


use App\Entity\Exams\Exam;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;
use Symfony\Component\Security\Core\User\UserInterface;

class Command
{
    private $onboardingTraining;
    private $exam;
    private $user;
    private $answers;
    private $responder;

    public function __construct(
        OnboardingTraining $onboardingTraining,
        Exam $exam,
        UserInterface $user,
        ?array $answers
    )
    {
        $this->onboardingTraining = $onboardingTraining;
        $this->exam = $exam;
        $this->user = $user;
        $this->answers = $answers;
        $this->responder = new NullResponder();
    }

    /**
     * @return OnboardingTraining
     */
    public function getOnboardingTraining(): OnboardingTraining
    {
        return $this->onboardingTraining;
    }

    /**
     * @return Exam
     */
    public function getExam(): Exam
    {
        return $this->exam;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array|null
     */
    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    public function getResponder(): Responder
    {
        return $this->responder;
    }

    public function setResponder(Responder $responder): self
    {
        $this->responder = $responder;

        return $this;
    }
}