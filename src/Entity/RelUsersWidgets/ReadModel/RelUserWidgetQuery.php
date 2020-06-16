<?php


namespace App\Entity\RelUsersWidgets\ReadModel;


use App\Entity\Users\User;

interface RelUserWidgetQuery
{
    /**
     * @param User $user
     * @return EndangeredDatesUser[]
     */
    public function endangeredDatesByDivision(User $user);

    /**
     * @param User $user
     * @return EndangeredDatesUser[]
     */
    public function endangeredDatesByCoach(User $user);
}