<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:11
 */

namespace App\Entity\Emails\Email;


final class Category
{
    const ADMINISTRATIVE = 'Administracyjne';
    const ONBOARDING = 'Onboarding';
    const DEADLINES_TRAINING = 'Terminy szkoleń';

    private $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function isAdministrative()
    {
        return $this->category === self::ADMINISTRATIVE;
    }

    public function isOnboarding()
    {
        return $this->category === self::ONBOARDING;
    }

    public function isDeadlinesTraining()
    {
        return $this->category === self::DEADLINES_TRAINING;
    }

    public function __toString()
    {
        return $this->category;
    }
}