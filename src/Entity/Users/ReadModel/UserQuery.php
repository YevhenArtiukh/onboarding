<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 11:00
 */

namespace App\Entity\Users\ReadModel;

use App\Entity\Users\User;

interface UserQuery
{
    /**
     * @return mixed
     */
    public function findAll(User $user);

    /**
     * @param string $token
     * @return User|null
     */
    public function passwordResetChange(string $token);
}