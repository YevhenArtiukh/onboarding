<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:21
 */

namespace App\Entity\Users\UseCase\CreateUser;


interface Responder
{
    public function userCreated();
    public function emailExists();
}