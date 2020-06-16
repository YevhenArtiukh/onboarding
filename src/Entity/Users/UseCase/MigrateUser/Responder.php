<?php


namespace App\Entity\Users\UseCase\MigrateUser;


interface Responder
{
    public function userMigrated();
    public function userWithEmailExist();
}