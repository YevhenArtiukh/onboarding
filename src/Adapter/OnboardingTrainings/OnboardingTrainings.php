<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 12:09
 */

namespace App\Adapter\OnboardingTrainings;

use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\OnboardingTrainings as OnboardingTrainingsInterface;
use App\Entity\Users\User;
use Doctrine\ORM\EntityManager;

class OnboardingTrainings implements OnboardingTrainingsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(OnboardingTraining $onboardingTraining)
    {
        $this->entityManager->persist($onboardingTraining);
    }

    public function delete(OnboardingTraining $onboardingTraining)
    {
        $this->entityManager->remove($onboardingTraining);
    }

    /**
     * @param int $id
     * @return OnboardingTraining|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(OnboardingTraining::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param int $day
     * @param \DateTimeInterface $time
     * @param Onboarding $onboarding
     * @param int $duration
     * @param int|null $id
     * @param Division|null $division
     * @return mixed
     */
    public function checkConflictTrainings(int $day, \DateTimeInterface $time, Onboarding $onboarding, int $duration, ?int $id = null, ?Division $division = null)
    {
        return $this->entityManager->getRepository(OnboardingTraining::class)->checkConflictTrainings(
            $day,
            $time,
            $onboarding,
            $duration,
            $id,
            $division
        );
    }

    /**
     * @param Onboarding $onboarding
     * @return mixed
     */
    public function findGeneralInOnboarding(Onboarding $onboarding)
    {
        return $this->entityManager->getRepository(OnboardingTraining::class)->findGeneralInOnboarding(
            $onboarding
        );
    }

    /**
     * @param Onboarding $onboarding
     * @param Division $division
     * @return mixed
     */
    public function findDivisionInOnboarding(Onboarding $onboarding, Division $division)
    {
        return $this->entityManager->getRepository(OnboardingTraining::class)->findDivisionInOnboarding(
            $onboarding,
            $division
        );
    }

    /**
     * @param Onboarding $onboarding
     * @param User $user
     * @return mixed
     */
    public function findAllNotInOnboardingForUser(Onboarding $onboarding, User $user)
    {
        return $this->entityManager->getRepository(OnboardingTraining::class)->findAllNotInOnboardingForUser(
            $onboarding,
            $user
        );
    }
}