<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 13:13
 */

namespace App\Entity\Questions\UseCase\CreateQuestion;


interface Responder
{
    public function questionCreated();
    public function correctAnswerNotExist();
}