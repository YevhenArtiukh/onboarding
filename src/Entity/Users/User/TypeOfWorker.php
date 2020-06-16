<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:36
 */

namespace App\Entity\Users\User;


final class TypeOfWorker
{
    const TYPE_OF_WORKER_OFFICE = 'biurowy';
    const TYPE_OF_WORKER_FIELD = 'terenowy';

    private $typeOfWorker;

    public function __construct($typeOfWorker)
    {
        $this->typeOfWorker = $typeOfWorker;
    }

    public function isOfficeWorker()
    {
        return $this->typeOfWorker === self::TYPE_OF_WORKER_OFFICE;
    }

    public function isFieldWorker()
    {
        return $this->typeOfWorker === self::TYPE_OF_WORKER_FIELD;
    }

    public function __toString()
    {
        return $this->typeOfWorker;
    }
}