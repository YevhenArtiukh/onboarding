<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:12
 */

namespace App\Entity\Emails\UseCase\CreateEmail;


interface Responder
{
    public function emailCreated(string $name);
    public function emailExists();
}