<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 14:22
 */

namespace App\Entity\Onboardings\ReadModel;


interface OnboardingQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}