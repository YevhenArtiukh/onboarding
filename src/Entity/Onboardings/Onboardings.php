<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:21
 */

namespace App\Entity\Onboardings;


interface Onboardings
{
    public function add(Onboarding $onboarding);
    public function delete(Onboarding $onboarding);

    /**
     * @param int $id
     * @return Onboarding|null
     */
    public function findOneById(int $id);

    /**
     * @param Onboarding $onboarding
     * @return Onboarding|null
     */
    public function getLastOnboardingForCopy(Onboarding $onboarding);
}