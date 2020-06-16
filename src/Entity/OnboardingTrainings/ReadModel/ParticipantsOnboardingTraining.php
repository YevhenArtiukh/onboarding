<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 14:17
 */

namespace App\Entity\OnboardingTrainings\ReadModel;


class ParticipantsOnboardingTraining
{
    private $id;
    private $name;
    private $surname;
    private $department;
    private $managerName;
    private $managerSurname;
    private $date;
    private $score;
    private $userConfirmation;
    private $coachConfirmation;
    private $datetime;

    public function __construct(
        int $id,
        string $name,
        string $surname,
        string $department,
        ?string $managerName,
        ?string $managerSurname,
        ?string $date,
        int $score,
        bool $userConfirmation,
        bool $coachConfirmation,
        ?\DateTime $datetime
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->department = $department;
        $this->managerName = $managerName;
        $this->managerSurname = $managerSurname;
        $this->score = $score;
        $this->date = $date;
        $this->userConfirmation = $userConfirmation;
        $this->coachConfirmation = $coachConfirmation;
        $this->datetime = $datetime;
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
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return null|string
     */
    public function getManagerName(): ?string
    {
        return $this->managerName;
    }

    /**
     * @return null|string
     */
    public function getManagerSurname(): ?string
    {
        return $this->managerSurname;
    }

    public function getManagerFullName(): ?string
    {
        return $this->managerName . ' ' . $this->managerSurname;
    }

    /**
     * @return null|string
     */
    public function getDate(): ?string
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
    public function isUserConfirmation(): string
    {
        return $this->userConfirmation ? 'Tak' : 'Nie';
    }

    /**
     * @return string
     */
    public function isCoachConfirmation(): string
    {
        return $this->coachConfirmation ? 'Tak' : 'Nie';
    }

    /**
     * @return string|null
     */
    public function getDatetime(): ?string
    {
        return $this->datetime ? $this->datetime->format('d.m.Y') : null;
    }
}