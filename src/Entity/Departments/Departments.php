<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 17:58
 */

namespace App\Entity\Departments;


use App\Entity\Divisions\Division;

interface Departments
{
    public function add(Department $department);
    public function delete(Department $department);

    /**
     * @param int $id
     * @return Department|null
     */
    public function findOneById(int $id);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param Division $division
     * @return Department|null
     */
    public function findFirstLevelInDivision(Division $division);
}