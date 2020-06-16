<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 13:04
 */

namespace App\Adapter\PresenceParticipants;

use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\PresenceParticipants\PresenceParticipant;
use App\Entity\PresenceParticipants\PresenceParticipants as PresenceParticipantsInterface;
use App\Entity\Users\User;
use Doctrine\ORM\EntityManager;

class PresenceParticipants implements PresenceParticipantsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(PresenceParticipant $presenceParticipant)
    {
        $this->entityManager->persist($presenceParticipant);
    }

    /**
     * @param OnboardingTraining $onboardingTraining
     * @param User $user
     * @return PresenceParticipant|null
     */
    public function findOneByOnboardingTrainingAndUser(OnboardingTraining $onboardingTraining, User $user)
    {
        return $this->entityManager->getRepository(PresenceParticipant::class)->findOneBy([
            'onboardingTraining' => $onboardingTraining,
            'user' => $user
        ]);
    }
}