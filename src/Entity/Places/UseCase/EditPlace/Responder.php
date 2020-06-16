<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:45
 */

namespace App\Entity\Places\UseCase\EditPlace;


interface Responder
{
    public function placeNotFound();
    public function placeEdited();
}