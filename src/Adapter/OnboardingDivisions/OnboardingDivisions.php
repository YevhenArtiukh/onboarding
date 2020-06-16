<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:28
 */

namespace App\Adapter\OnboardingDivisions;

use App\Entity\Divisions\Division;
use App\Entity\OnboardingDivisions\OnboardingDivision;
use App\Entity\OnboardingDivisions\OnboardingDivisions as OnboardingDivisionsInterface;
use App\Entity\Onboardings\Onboarding;
use Doctrine\ORM\EntityManager;

class OnboardingDivisions implements OnboardingDivisionsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(OnboardingDivision $onboardingDivision)
    {
        $this->entityManager->persist($onboardingDivision);
    }

    public function delete(OnboardingDivision $onboardingDivision)
    {
        $this->entityManager->remove($onboardingDivision);
    }

    /**
     * @param int $id
     * @return OnboardingDivision|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(OnboardingDivision::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param Onboarding $onboarding
     * @param Division $division
     * @return OnboardingDivision|null
     */
    public function findOneByOnboardingAndDivision(Onboarding $onboarding, Division $division)
    {
        return $this->entityManager->getRepository(OnboardingDivision::class)->findOneBy([
            'onboarding' => $onboarding,
            'division' => $division
        ]);
    }
}