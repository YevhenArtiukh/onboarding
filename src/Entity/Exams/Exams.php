<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 11:57
 */

namespace App\Entity\Exams;


use App\Entity\Trainings\Training;

interface Exams
{
    public function add(Exam $exam);
    public function delete(Exam $exam);

    /**
     * @param int $id
     * @return Exam|null
     */
    public function findOneById(int $id);

    /**
     * @param Training $training
     * @return Exam|null
     */
    public function findOneByTrainingIDAndActive(Training $training);
}