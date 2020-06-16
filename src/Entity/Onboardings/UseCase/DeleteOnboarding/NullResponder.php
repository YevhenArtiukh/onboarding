<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 17:23
 */

namespace App\Entity\Onboardings\UseCase\DeleteOnboarding;


final class NullResponder implements Responder
{

    public function onboardingNotFound()
    {

    }

    public function onboardingDeleted()
    {

    }
}