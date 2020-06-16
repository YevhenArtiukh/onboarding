<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-16
 * Time: 11:55
 */

namespace App\Entity\Onboardings\UseCase\EditUserOnboarding;


interface Responder
{
    public function userNotFound();
    public function userEdited();
}