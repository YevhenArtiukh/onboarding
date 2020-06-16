<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 17:35
 */

namespace App\Entity\Divisions\ReadModel;


interface DivisionQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}