<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-24
 * Time: 12:09
 */

namespace App\Adapter\UserResults;

use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\UserResults\UserResult;
use App\Entity\UserResults\UserResults as UserResultsInterface;
use App\Entity\Users\User;
use Doctrine\ORM\EntityManager;

class UserResults implements UserResultsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(UserResult $userResult)
    {
        $this->entityManager->persist($userResult);
    }

    public function delete(UserResult $userResult)
    {
        $this->entityManager->remove($userResult);
    }

    /**
     * @param OnboardingTraining $onboardingTraining
     * @param User $user
     * @return UserResult|null
     */
    public function findOneByOnboardingTrainingAndUser(OnboardingTraining $onboardingTraining, User $user)
    {
        return $this->entityManager->getRepository(UserResult::class)->findOneBy([
            'onboardingTraining' => $onboardingTraining,
            'user' => $user
        ]);
    }
}