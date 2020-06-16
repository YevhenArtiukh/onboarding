<?php


namespace App\Entity\UserResults\ReadModel;


use App\Entity\Users\User;

interface UserResultsQuery
{
    /**
     * @param User $user
     * @return mixed
     */
    public function getAllByUser(User $user);
}