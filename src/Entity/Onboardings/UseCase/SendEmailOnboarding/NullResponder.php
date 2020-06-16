<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 13:43
 */

namespace App\Entity\Onboardings\UseCase\SendEmailOnboarding;


final class NullResponder implements Responder
{

    public function emailSent()
    {

    }
}