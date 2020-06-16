<?php


namespace App\Entity\Trainings\Training;


class TypeOfTraining
{
    const TYPE_OF_TRAINING_STATIONARY = 'stationary';
    const TYPE_OF_TRAINING_ONLINE = 'online';
    const TYPE_OF_TRAINING_PAUSE = 'pause';

    private $typeOfTraining;

    public function __construct($typeOfTraining)
    {
        $this->typeOfTraining = $typeOfTraining;
    }

    public function isStationary(){
        return $this->typeOfTraining === self::TYPE_OF_TRAINING_STATIONARY;
    }
    public function isOnline(){
        return $this->typeOfTraining === self::TYPE_OF_TRAINING_ONLINE;
    }
    public function isPause(){
        return $this->typeOfTraining === self::TYPE_OF_TRAINING_PAUSE;
    }

    public function __toString()
    {
        return $this->typeOfTraining;
    }

}