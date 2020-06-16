<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-25
 * Time: 12:37
 */

namespace App\Entity\Departments\ReadModel;


interface DepartmentQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}