<?php


namespace App\Entity\RelUsersWidgets\ReadModel;


use App\Entity\Users\User;

class EndangeredDatesUser
{
    private $name;
    private $surname;
    private $trainingName;
    private $division;
    private $department;
    private $onboardingDays;
    private $day;


    public function __construct(
        string $name,
        string $surname,
        string $trainingName,
        string $division,
        string $department,
        array $onboardingDays,
        string $day
    )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->trainingName = $trainingName;
        $this->division = $division;
        $this->department = $department;
        $this->onboardingDays = $onboardingDays;
        $this->day = $day;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getTrainingName(): string
    {
        return $this->trainingName;
    }

    /**
     * @return string
     */
    public function getDivision(): string
    {
        return $this->division;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return array
     */
    public function getOnboardingDays(): array
    {
        return $this->onboardingDays;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    public function getOnboardingDate()
    {
        if($this->getOnboardingDays())
            return $this->getOnboardingDays()[0]['day'];
        return null;
    }

}