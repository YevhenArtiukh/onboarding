<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 12:16
 */

namespace App\Entity\OnboardingTrainings\ReadModel;


use App\Entity\Trainings\Training\KindOfTraining;

class CoachOnboardingTraining
{
    private $id;
    private $startTime;
    private $trainingDay;
    private $name;
    private $duration;
    private $isAdditional;
    private $kindOfTraining;
    private $day;
    private $count;
    private $onboardingDays;
    private $onboardingDivisionDays;

    public function __construct(
        int $id,
        string $startTime,
        int $trainingDay,
        string $name,
        int $duration,
        bool $isAdditional,
        string $kindOfTraining,
        string $day,
        int $count,
        array $onboardingDays,
        ?array $onboardingDivisionDays
    )
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->trainingDay = $trainingDay;
        $this->name = $name;
        $this->duration = $duration;
        $this->isAdditional = $isAdditional;
        $this->kindOfTraining = $kindOfTraining;
        $this->day = $day;
        $this->count = $count;
        $this->onboardingDays = $onboardingDays;
        $this->onboardingDivisionDays = $onboardingDivisionDays;
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
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @return int
     */
    public function getTrainingDay(): int
    {
        return $this->trainingDay;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return bool
     */
    public function isAdditional(): bool
    {
        return $this->isAdditional;
    }

    /**
     * @return string
     */
    public function getKindOfTraining(): string
    {
        return $this->kindOfTraining;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return array
     */
    public function getOnboardingDays(): array
    {
        return $this->onboardingDays;
    }

    /**
     * @return array|null
     */
    public function getOnboardingDivisionDays(): ?array
    {
        return $this->onboardingDivisionDays;
    }

    public function getDate()
    {
        return date_modify(new \DateTime($this->day), '+'.((int)$this->trainingDay - 1).' day')->format('d.m.Y');
    }

    public function getTime()
    {
        if(!$this->isAdditional)
            return ((new \DateTime($this->startTime))->format('H:i').' - '.(date_modify(new \DateTime($this->startTime), '+'.$this->duration.' min'))->format('H:i'));
        return null;
    }

    public function getLocalization()
    {
        if($this->isAdditional)
            return null;

        if($this->kindOfTraining === KindOfTraining::KIND_OF_TRAINING_GENERAL)
            return $this->onboardingDays[($this->trainingDay-1)]['place']->getName().', '.$this->onboardingDays[($this->trainingDay-1)]['hall'];

        $temp = date_diff(new \DateTime(end($this->onboardingDays)['day']), new \DateTime(reset($this->onboardingDivisionDays)['day']))->format('%d');

        return $this->onboardingDivisionDays[$this->trainingDay-(count($this->onboardingDays)+$temp)]['place']->getName().', '.$this->onboardingDivisionDays[$this->trainingDay-(count($this->onboardingDays)+$temp)]['hall'];
    }
}