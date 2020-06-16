<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 13:27
 */

namespace App\Entity\Emails\UseCase\EditEmail;


interface Responder
{
    public function emailNotFound();
    public function emailEdited();
}