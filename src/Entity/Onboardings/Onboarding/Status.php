<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 17:13
 */

namespace App\Entity\Onboardings\Onboarding;


final class Status
{
    const STATUS_GENERAL = 'general';
    const STATUS_DIVISION = 'division';

    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function isGeneral()
    {
        return $this->status === self::STATUS_GENERAL;
    }

    public function isDivisions()
    {
        return $this->status === self::STATUS_DIVISION;
    }

    public function __toString()
    {
        return $this->status;
    }
}