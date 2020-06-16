<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-28
 * Time: 14:53
 */

namespace App\Entity\Reports\ReadModel;


class ExportDataDateBetween
{
    private $userId;
    private $userName;
    private $userSurname;
    private $userStatus;
    private $managerName;
    private $managerSurname;
    private $businessPartnerName;
    private $businessPartnerSurname;
    private $division;
    private $department;
    private $parentDepartment;
    private $onboardingDay;
    private $onboardingId;
    private $training;
    private $score;
    private $date;
    private $try;

    public function __construct(
        int $userId,
        string $userName,
        string $userSurname,
        string $userStatus,
        ?string $managerName,
        ?string $managerSurname,
        ?string $businessPartnerName,
        ?string $businessPartnerSurname,
        string $division,
        string $department,
        ?string $parentDepartment,
        \DateTime $onboardingDay,
        int $onboardingId,
        ?string $training,
        ?int $score,
        ?\DateTime $date,
        int $try
    )
    {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->userSurname = $userSurname;
        $this->userStatus = $userStatus;
        $this->managerName = $managerName;
        $this->managerSurname = $managerSurname;
        $this->businessPartnerName = $businessPartnerName;
        $this->businessPartnerSurname = $businessPartnerSurname;
        $this->division = $division;
        $this->department = $department;
        $this->parentDepartment = $parentDepartment;
        $this->onboardingDay = $onboardingDay;
        $this->onboardingId = $onboardingId;
        $this->training = $training;
        $this->score = $score;
        $this->date = $date;
        $this->try = $try;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getUserSurname(): string
    {
        return $this->userSurname;
    }

    /**
     * @return string
     */
    public function getUserStatus(): string
    {
        return $this->userStatus;
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

    /**
     * @return null|string
     */
    public function getBusinessPartnerName(): ?string
    {
        return $this->businessPartnerName;
    }

    /**
     * @return null|string
     */
    public function getBusinessPartnerSurname(): ?string
    {
        return $this->businessPartnerSurname;
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
     * @return null|string
     */
    public function getParentDepartment(): ?string
    {
        return $this->parentDepartment;
    }

    /**
     * @return \DateTime
     */
    public function getOnboardingDay(): \DateTime
    {
        return $this->onboardingDay;
    }

    /**
     * @return int
     */
    public function getOnboardingId(): int
    {
        return $this->onboardingId;
    }

    /**
     * @return null|string
     */
    public function getTraining(): ?string
    {
        return $this->training;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getTry(): int
    {
        return $this->try;
    }
}