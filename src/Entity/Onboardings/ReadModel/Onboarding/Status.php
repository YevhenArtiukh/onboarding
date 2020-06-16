<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 15:58
 */

namespace App\Entity\Onboardings\ReadModel\Onboarding;

use App\Entity\Onboardings\Onboarding\Status as OnboardingStatus;

final class Status
{
    private $status;
    private static $statusesTranslation = [
        OnboardingStatus::STATUS_GENERAL => 'Cross dywizyjne',
        OnboardingStatus::STATUS_DIVISION => 'dywizja'
    ];

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function __toString()
    {
        if(isset(self::$statusesTranslation[$this->status]))
            return self::$statusesTranslation[$this->status];

        return $this->getOriginalStatus();
    }

    public function getOriginalStatus(): string
    {
        return $this->status;
    }

    public function isGeneral()
    {
        return $this->status === OnboardingStatus::STATUS_GENERAL;
    }

    public function isDivisions()
    {
        return $this->status === OnboardingStatus::STATUS_DIVISION;
    }
}