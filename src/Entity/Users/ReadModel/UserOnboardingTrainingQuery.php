<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-23
 * Time: 12:01
 */

namespace App\Entity\Users\ReadModel;

use App\Entity\Users\User;

interface UserOnboardingTrainingQuery
{
    /**
     * @param User $user
     * @return mixed
     */
    public function findAllForUser(User $user);
}