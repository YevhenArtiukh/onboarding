<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:17
 */

namespace App\Entity\Trainings;


interface Trainings
{
    public function add(Training $training);
    public function delete(Training $training);

    /**
     * @param int $id
     * @return Training|null
     */
    public function findOneById(int $id);
}