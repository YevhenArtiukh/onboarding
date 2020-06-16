<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:02
 */

namespace App\Entity\Permissions\UseCase\CreatePermission;


final class NullResponder implements Responder
{

    public function permissionCreated(string $namePermission)
    {

    }

    public function functionExists()
    {

    }
}