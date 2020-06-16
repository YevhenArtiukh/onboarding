<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:43
 */

namespace App\Entity\Questions;


use App\Entity\Exams\Exam;

interface Questions
{
    public function add(Question $question);
    public function delete(Question $question);

    /**
     * @param int $id
     * @return Question|null
     */
    public function findOneById(int $id);

    /**
     * @param Exam $exam
     * @return Question|null
     */
    public function findLastInExam(Exam $exam);
}