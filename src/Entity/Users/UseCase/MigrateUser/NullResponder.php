<?php


namespace App\Entity\Users\UseCase\MigrateUser;


final class NullResponder implements Responder
{

    public function userMigrated(){}

    public function userWithEmailExist(){}
}