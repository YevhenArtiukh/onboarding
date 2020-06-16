<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:08
 */

namespace App\Entity\Roles\UseCase\CreateRole;


interface Responder
{
    public function roleCreated(string $roleName);
    public function roleNameExists();
}