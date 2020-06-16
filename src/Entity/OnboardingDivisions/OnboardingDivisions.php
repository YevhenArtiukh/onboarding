<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:27
 */

namespace App\Entity\OnboardingDivisions;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;

interface OnboardingDivisions
{
    public function add(OnboardingDivision $onboardingDivision);

    public function delete(OnboardingDivision $onboardingDivision);

    /**
     * @param int $id
     * @return OnboardingDivision|null
     */
    public function findOneById(int $id);

    /**
     * @param Onboarding $onboarding
     * @param Division $division
     * @return OnboardingDivision|null
     */
    public function findOneByOnboardingAndDivision(Onboarding $onboarding, Division $division);
}