<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:17
 */

namespace App\Entity\Places;


interface Places
{
    public function add(Place $place);
    public function delete(Place $place);

    /**
     * @param int $id
     * @return Place|null
     */
    public function findOneById(int $id);
}