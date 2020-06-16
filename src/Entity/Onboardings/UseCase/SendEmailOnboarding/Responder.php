<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 13:42
 */

namespace App\Entity\Onboardings\UseCase\SendEmailOnboarding;


interface Responder
{
    public function emailSent();
}