<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-22
 * Time: 15:19
 */

namespace App\Entity\Departments\ReadModel;


use App\Entity\Divisions\Division;
use App\Entity\Users\User;

interface BusinessPartnerQuery
{
    /**
     * @param Division $division
     * @return mixed
     */
    public function findAll(Division $division);

    /**
     * @param User|null $user
     * @param Division $division
     * @return mixed
     */
    public function findByIdBusinessPartner(?User $user, Division $division);
}