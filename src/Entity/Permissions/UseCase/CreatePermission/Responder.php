<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:01
 */

namespace App\Entity\Permissions\UseCase\CreatePermission;


interface Responder
{
    public function permissionCreated(string $namePermission);
    public function functionExists();
}