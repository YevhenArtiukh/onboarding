<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-02
 * Time: 12:58
 */

namespace App\Entity\Reports\ReadModel;


class NumberOfParticipants
{
    private $onboardingId;
    private $onboardingDays;
    private $countUsers;

    public function __construct(
        int $onboardingId,
        array $onboardingDays,
        int $countUsers
    )
    {
        $this->onboardingId = $onboardingId;
        $this->onboardingDays = $onboardingDays;
        $this->countUsers = $countUsers;
    }

    /**
     * @return int
     */
    public function getOnboardingId(): int
    {
        return $this->onboardingId;
    }

    /**
     * @return array
     */
    public function getOnboardingDays(): array
    {
        return $this->onboardingDays;
    }

    /**
     * @return int
     */
    public function getCountUsers(): int
    {
        return $this->countUsers;
    }

    public function getDateStart(): \DateTime
    {
        $days = $this->onboardingDays;

        return new \DateTime(reset($days)['day']);
    }
}