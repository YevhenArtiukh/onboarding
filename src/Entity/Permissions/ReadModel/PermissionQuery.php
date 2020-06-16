<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:37
 */

namespace App\Entity\Permissions\ReadModel;


interface PermissionQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}