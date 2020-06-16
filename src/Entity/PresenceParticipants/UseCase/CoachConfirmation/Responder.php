<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 15:02
 */

namespace App\Entity\PresenceParticipants\UseCase\CoachConfirmation;


interface Responder
{
    public function confirmed();
    public function userNotFound();
}