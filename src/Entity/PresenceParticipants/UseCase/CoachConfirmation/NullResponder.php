<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 15:02
 */

namespace App\Entity\PresenceParticipants\UseCase\CoachConfirmation;


final class NullResponder implements Responder
{

    public function confirmed()
    {

    }

    public function userNotFound()
    {

    }
}