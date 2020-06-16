<?php


namespace App\Entity\Users\ReadModel;


interface UserMigrationQuery
{
    public function findByParams(array $params);
}