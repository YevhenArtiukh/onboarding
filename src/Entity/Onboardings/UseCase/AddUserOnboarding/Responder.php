<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 14:44
 */

namespace App\Entity\Onboardings\UseCase\AddUserOnboarding;


interface Responder
{
    public function userCreated();
    public function emailExists();
}