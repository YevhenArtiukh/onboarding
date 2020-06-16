<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:25
 */

namespace App\Entity\Roles\UseCase\EditRole;


interface Responder
{
    public function roleNotFound();
    public function roleEdited();
    public function roleNameExists();
}