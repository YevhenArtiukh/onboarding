<?php

namespace App\Entity\OnboardingDivisions;

use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OnboardingDivisions\OnboardingDivisionRepository")
 */
class OnboardingDivision
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Onboardings\Onboarding", inversedBy="onboardingDivisions")
     */
    private $onboarding;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Divisions\Division", inversedBy="onboardingDivisions")
     */
    private $division;

    /**
     * @ORM\Column(type="array")
     */
    private $days = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmation;

    public function __construct(
        Onboarding $onboarding,
        Division $division,
        array $days
    )
    {
        $this->onboarding = $onboarding;
        $this->division = $division;
        $this->days = $days;
        $this->confirmation = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnboarding(): ?Onboarding
    {
        return $this->onboarding;
    }

    public function setOnboarding(?Onboarding $onboarding): self
    {
        $this->onboarding = $onboarding;

        return $this;
    }

    public function getDivision(): ?Division
    {
        return $this->division;
    }

    public function setDivision(?Division $division): self
    {
        $this->division = $division;

        return $this;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(array $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getConfirmation(): ?bool
    {
        return $this->confirmation;
    }

    public function setConfirmation(bool $confirmation): self
    {
        $this->confirmation = $confirmation;

        return $this;
    }
}
