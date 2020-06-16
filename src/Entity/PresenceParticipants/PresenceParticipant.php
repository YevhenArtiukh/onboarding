<?php

namespace App\Entity\PresenceParticipants;

use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PresenceParticipants\PresenceParticipantRepository")
 */
class PresenceParticipant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OnboardingTrainings\OnboardingTraining", inversedBy="presenceParticipants")
     */
    private $onboardingTraining;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User", inversedBy="presenceParticipantsUser")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User", inversedBy="presenceParticipantsCoach")
     */
    private $coach;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userConfirmation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $coachConfirmation;

    public function __construct(
        OnboardingTraining $onboardingTraining
    )
    {
        $this->onboardingTraining = $onboardingTraining;
        $this->userConfirmation = false;
        $this->coachConfirmation = false;
    }

    public function userConfirmation(
        User $user
    )
    {
        $this->user = $user;
        $this->userConfirmation = true;

        if($this->coachConfirmation && $this->userConfirmation)
            $this->datetime = new \DateTime();
        else
            $this->datetime = null;

        return $this;
    }

    public function coachConfirmation(
        User $coach
    )
    {
        $this->coach = $coach;
        $this->coachConfirmation = !$this->coachConfirmation;

        if($this->coachConfirmation && $this->userConfirmation)
            $this->datetime = new \DateTime();
        else
            $this->datetime = null;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnboardingTraining(): ?OnboardingTraining
    {
        return $this->onboardingTraining;
    }

    public function setOnboardingTraining(?OnboardingTraining $onboardingTraining): self
    {
        $this->onboardingTraining = $onboardingTraining;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCoach(): ?User
    {
        return $this->coach;
    }

    public function setCoach(?User $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getUserConfirmation(): ?bool
    {
        return $this->userConfirmation;
    }

    public function setUserConfirmation(bool $userConfirmation): self
    {
        $this->userConfirmation = $userConfirmation;

        return $this;
    }

    public function getCoachConfirmation(): ?bool
    {
        return $this->coachConfirmation;
    }

    public function setCoachConfirmation(bool $coachConfirmation): self
    {
        $this->coachConfirmation = $coachConfirmation;

        return $this;
    }
}
