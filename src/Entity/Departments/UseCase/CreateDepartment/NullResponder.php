<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 18:05
 */

namespace App\Entity\Departments\UseCase\CreateDepartment;


final class NullResponder implements Responder
{

    public function departmentCreated(string $departmentName)
    {

    }

    public function departmentFirstLevelExists()
    {

    }
}