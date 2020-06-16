<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 16:38
 */

namespace App\Entity\Divisions;


interface Divisions
{
    public function add(Division $division);
    public function delete(Division $division);

    /**
     * @param int $id
     * @return Division|null
     */
    public function findOneById(int $id);
}