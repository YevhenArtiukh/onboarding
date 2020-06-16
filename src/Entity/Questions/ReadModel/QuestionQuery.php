<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 16:32
 */

namespace App\Entity\Questions\ReadModel;


use App\Entity\Exams\Exam;

interface QuestionQuery
{
    /**
     * @param Exam $exam
     * @return mixed
     */
    public function findAllForExam(Exam $exam);
}