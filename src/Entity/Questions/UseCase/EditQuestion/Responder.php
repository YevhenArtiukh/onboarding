<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-06
 * Time: 12:49
 */

namespace App\Entity\Questions\UseCase\EditQuestion;


interface Responder
{
    public function questionNotFound();
    public function questionEdited();
}