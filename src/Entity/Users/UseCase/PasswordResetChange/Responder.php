<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 11:17
 */

namespace App\Entity\Users\UseCase\PasswordResetChange;


interface Responder
{
    public function passwordEdited();
}