<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:30
 */

namespace App\Entity\Places\ReadModel;


interface PlaceQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}