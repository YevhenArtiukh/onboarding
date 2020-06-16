<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:42
 */

namespace App\Entity\Roles\ReadModel;


interface RoleQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}