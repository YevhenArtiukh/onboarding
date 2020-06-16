<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 13:09
 */

namespace App\Entity\PresenceParticipants\UseCase\UserConfirmation;


interface Responder
{
    public function confirmed();
}