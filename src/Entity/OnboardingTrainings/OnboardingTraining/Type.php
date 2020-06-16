<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 12:47
 */

namespace App\Entity\OnboardingTrainings\OnboardingTraining;


final class Type
{
    const TYPE_TEST = 'Wypełnienie testu';
    const TYPE_PRESENCE = 'Zaliczenie przez obecność';

    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function isTypeTest()
    {
        return $this->type === self::TYPE_TEST;
    }

    public function isTypePresence()
    {
        return $this->type === self::TYPE_PRESENCE;
    }

    public function __toString()
    {
        return $this->type;
    }
}