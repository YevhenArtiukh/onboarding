<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-23
 * Time: 12:01
 */

namespace App\Entity\Users\ReadModel;


use App\Entity\OnboardingTrainings\OnboardingTraining\Type;

class UserOnboardingTraining
{
    private $onboardingTrainingId;
    private $trainingName;
    private $firstDay;
    private $trainingDay;
    private $coaches;
    private $score;
    private $onboardingTrainingType;
    private $trainingIsAdditional;

    public function __construct(
        int $onboardingTrainingId,
        string $trainingName,
        \DateTime $firstDay,
        int $trainingDay,
        ?string $coaches,
        int $score,
        string $onboardingTrainingType,
        bool $trainingIsAdditional
    )
    {
        $this->onboardingTrainingId = $onboardingTrainingId;
        $this->trainingName = $trainingName;
        $this->firstDay = $firstDay;
        $this->trainingDay = $trainingDay;
        $this->coaches = $coaches;
        $this->score = $score;
        $this->onboardingTrainingType = $onboardingTrainingType;
        $this->trainingIsAdditional = $trainingIsAdditional;
    }

    /**
     * @return int
     */
    public function getOnboardingTrainingId(): int
    {
        return $this->onboardingTrainingId;
    }

    /**
     * @return string
     */
    public function getTrainingName(): string
    {
        return $this->trainingName;
    }

    /**
     * @return \DateTime
     */
    public function getFirstDay(): \DateTimeInterface
    {
        return $this->firstDay;
    }

    /**
     * @return int
     */
    public function getTrainingDay()
    {
        return $this->trainingDay;
    }

    /**
     * @return null|string
     */
    public function getCoaches(): ?string
    {
        return $this->coaches;
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
    public function getOnboardingTrainingType(): string
    {
        return $this->onboardingTrainingType;
    }

    /**
     * @return bool
     */
    public function isTrainingIsAdditional(): bool
    {
        return $this->trainingIsAdditional;
    }

    public function isTest(): bool
    {
        return $this->onboardingTrainingType === Type::TYPE_TEST;
    }

    public function getDeadline()
    {
        $date = $this->firstDay;
        return date_modify($date, '+'.($this->trainingDay-1).' days');
    }
}