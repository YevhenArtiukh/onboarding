<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:26
 */

namespace App\Entity\Roles\UseCase\EditRole;


final class NullResponder implements Responder
{
    public function roleNotFound()
    {

    }

    public function roleEdited()
    {

    }

    public function roleNameExists()
    {

    }
}