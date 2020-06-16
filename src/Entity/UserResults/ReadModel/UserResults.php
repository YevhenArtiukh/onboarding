<?php


namespace App\Entity\UserResults\ReadModel;


use App\Entity\Exams\Exam\Type;

class UserResults
{
    private $id;
    private $name;
    private $date;
    private $score;
    private $currentExamType;
    private $onboardingTrainingType;


    public function __construct(
        int $id,
        string $name,
        \DateTime $date,
        int $score,
        string $currentExamType,
        string $onboardingTrainingType
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->score = $score;
        $this->currentExamType = $currentExamType;
        $this->onboardingTrainingType = $onboardingTrainingType;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getCurrentExamType(): string
    {
        return $this->currentExamType;
    }

    public function isTest(): bool
    {
        return $this->currentExamType === Type::TYPE_TEST;
    }

    /**
     * @return string
     */
    public function getOnboardingTrainingType(): string
    {
        return $this->onboardingTrainingType;
    }

    public function isPresence(): bool
    {
        return $this->currentExamType === \App\Entity\OnboardingTrainings\OnboardingTraining\Type::TYPE_PRESENCE;
    }



}