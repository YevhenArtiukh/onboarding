<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:28
 */

namespace App\Entity\Exams\ReadModel;


use App\Entity\Trainings\Training;

interface ExamQuery
{
    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param Training $training
     */
    public function getAllByTraining(Training $training);
}