<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 12:09
 */

namespace App\Entity\OnboardingTrainings;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Users\User;

interface OnboardingTrainings
{
    public function add(OnboardingTraining $onboardingTraining);

    public function delete(OnboardingTraining $onboardingTraining);

    /**
     * @param int $id
     * @return OnboardingTraining|null
     */
    public function findOneById(int $id);

    /**
     * @param int $day
     * @param \DateTimeInterface $time
     * @param Onboarding $onboarding
     * @param int $duration
     * @param int|null $id
     * @return mixed
     */
    public function checkConflictTrainings(int $day, \DateTimeInterface $time, Onboarding $onboarding, int $duration, ?int $id = null, ?Division $division = null);

    /**
     * @param Onboarding $onboarding
     * @return mixed
     */
    public function findGeneralInOnboarding(Onboarding $onboarding);

    /**
     * @param Onboarding $onboarding
     * @param Division $division
     * @return mixed
     */
    public function findDivisionInOnboarding(Onboarding $onboarding, Division $division);

    /**
     * @param Onboarding $onboarding
     * @param User $user
     * @return mixed
     */
    public function findAllNotInOnboardingForUser(Onboarding $onboarding, User $user);
}