<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:25
 */

namespace App\Entity\Trainings\Training;


final class KindOfTraining
{
    const KIND_OF_TRAINING_GENERAL = 'general';
    const KIND_OF_TRAINING_DIVISIONS = 'division';

    private $kindOfTraining;

    public function __construct($kindOfTraining)
    {
        $this->kindOfTraining = $kindOfTraining;
    }

    public function isGeneral()
    {
        return $this->kindOfTraining === self::KIND_OF_TRAINING_GENERAL;
    }

    public function isDivisions()
    {
        return $this->kindOfTraining === self::KIND_OF_TRAINING_DIVISIONS;
    }

    public function __toString()
    {
        return $this->kindOfTraining;
    }
}