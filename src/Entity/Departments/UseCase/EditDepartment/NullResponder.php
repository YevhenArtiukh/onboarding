<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-25
 * Time: 14:08
 */

namespace App\Entity\Departments\UseCase\EditDepartment;


final class NullResponder implements Responder
{

    public function departmentNotFound()
    {

    }

    public function departmentEdited()
    {

    }

    public function departmentFirstLevelExists()
    {

    }

    public function errorBuildTree()
    {

    }
}