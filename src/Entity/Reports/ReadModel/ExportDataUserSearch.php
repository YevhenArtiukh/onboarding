<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-29
 * Time: 13:54
 */

namespace App\Entity\Reports\ReadModel;


class ExportDataUserSearch
{
    private $userId;
    private $userName;
    private $userSurname;
    private $userLogin;
    private $managerName;
    private $managerSurname;
    private $businessPartnerName;
    private $businessPartnerSurname;
    private $department;

    private $onboardingDay;
    private $training;
    private $score;
    private $date;
    private $try;

    public function __construct(
        int $userId,
        string $userName,
        string $userSurname,
        string $userLogin,
        ?string $managerName,
        ?string $managerSurname,
        ?string $businessPartnerName,
        ?string $businessPartnerSurname,
        string $department,
        ?\DateTime $onboardingDay,
        ?string $training,
        ?int $score,
        ?\DateTime $date,
        ?int $try
    )
    {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->userSurname = $userSurname;
        $this->userLogin = $userLogin;
        $this->managerName = $managerName;
        $this->managerSurname = $managerSurname;
        $this->businessPartnerName = $businessPartnerName;
        $this->businessPartnerSurname = $businessPartnerSurname;
        $this->department = $department;
        $this->onboardingDay = $onboardingDay;
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
    public function getUserLogin(): string
    {
        return $this->userLogin;
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
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return \DateTime|null
     */
    public function getOnboardingDay(): ?\DateTime
    {
        return $this->onboardingDay;
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
     * @return int|null
     */
    public function getTry(): ?int
    {
        return $this->try;
    }
}