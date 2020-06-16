<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 16:06
 */

namespace App\Entity\Answers;


use App\Entity\Questions\Question;

interface Answers
{
    public function add(Answer $answer);
    public function delete(Answer $answer);

    /**
     * @param int $id
     * @return Answer|null
     */
    public function findOneById(int $id);

    /**
     * @param Question $question
     * @return mixed
     */
    public function findByQuestion(Question $question);
}