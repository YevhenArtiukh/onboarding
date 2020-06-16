<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:24
 */

namespace App\Adapter\Onboardings;

use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\Onboardings as OnboardingsInterface;
use Doctrine\ORM\EntityManager;

class Onboardings implements OnboardingsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Onboarding $onboarding)
    {
        $this->entityManager->persist($onboarding);
    }

    public function delete(Onboarding $onboarding)
    {
        $this->entityManager->remove($onboarding);
    }

    /**
     * @param int $id
     * @return Onboarding|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Onboarding::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param Onboarding $onboarding
     * @return Onboarding|null
     */
    public function getLastOnboardingForCopy(Onboarding $onboarding)
    {
        return $this->entityManager->getRepository(Onboarding::class)->getLastOnboardingForCopy(
            $onboarding
        );
    }
}