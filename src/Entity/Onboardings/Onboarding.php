<?php

namespace App\Entity\Onboardings;

use App\Entity\Divisions\Division;
use App\Entity\OnboardingDivisions\OnboardingDivision;
use App\Entity\Onboardings\Onboarding\Status;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Onboardings\OnboardingRepository")
 */
class Onboarding
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $days = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OnboardingTrainings\OnboardingTraining", mappedBy="onboarding", cascade={"remove"})
     * @ORM\OrderBy({"time" = "ASC", "day" = "ASC"})
     */
    private $onboardingTrainings;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users\User", mappedBy="onboarding")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OnboardingDivisions\OnboardingDivision", mappedBy="onboarding", cascade={"remove"})
     */
    private $onboardingDivisions;

    public function __construct(
        array $days
    )
    {
        $this->days = $days;
        $this->status = Status::STATUS_GENERAL;
        $this->onboardingTrainings = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->onboardingDivisions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMonth()
    {
        $days = $this->days;

        $months = [
            '',
            'Styczeń',
            'Luty',
            'Marzec',
            'Kwiecień',
            'Maj',
            'Czerwiec',
            'Lipiec',
            'Sierpień',
            'Wrzesień',
            'Październik',
            'Listopad',
            'Grudzień'
        ];

        return $months[(new \DateTime(reset($days)['day']))->format('n')];
    }

    public function getDateStart(): \DateTime
    {
        $days = $this->days;

        return new \DateTime(reset($days)['day']);
    }

    public function getHallStart(): string
    {
        $days = $this->days;

        return reset($days)['hall'];
    }

    /**
     * @return Collection|OnboardingTraining[]
     */
    public function getOnboardingTrainings(): Collection
    {
        return $this->onboardingTrainings;
    }

    public function addOnboardingTraining(OnboardingTraining $onboardingTraining): self
    {
        if (!$this->onboardingTrainings->contains($onboardingTraining)) {
            $this->onboardingTrainings[] = $onboardingTraining;
            $onboardingTraining->setOnboarding($this);
        }

        return $this;
    }

    public function removeOnboardingTraining(OnboardingTraining $onboardingTraining): self
    {
        if ($this->onboardingTrainings->contains($onboardingTraining)) {
            $this->onboardingTrainings->removeElement($onboardingTraining);
            // set the owning side to null (unless already changed)
            if ($onboardingTraining->getOnboarding() === $this) {
                $onboardingTraining->setOnboarding(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isGeneral()
    {
        return $this->status === 'general';
    }

    public function isDivision()
    {
        return $this->status === 'division';
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setOnboarding($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getOnboarding() === $this) {
                $user->setOnboarding(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OnboardingDivision[]
     */
    public function getOnboardingDivisions(): Collection
    {
        return $this->onboardingDivisions;
    }

    public function addOnboardingDivision(OnboardingDivision $onboardingDivision): self
    {
        if (!$this->onboardingDivisions->contains($onboardingDivision)) {
            $this->onboardingDivisions[] = $onboardingDivision;
            $onboardingDivision->setOnboarding($this);
        }

        return $this;
    }

    public function removeOnboardingDivision(OnboardingDivision $onboardingDivision): self
    {
        if ($this->onboardingDivisions->contains($onboardingDivision)) {
            $this->onboardingDivisions->removeElement($onboardingDivision);
            // set the owning side to null (unless already changed)
            if ($onboardingDivision->getOnboarding() === $this) {
                $onboardingDivision->setOnboarding(null);
            }
        }

        return $this;
    }

    public function checkConfirmation(Division $division)
    {
        /** @var OnboardingDivision $onboardingDivision */
        foreach ($this->onboardingDivisions as $onboardingDivision) {
            if($onboardingDivision->getDivision() === $division) {
                return $onboardingDivision->getConfirmation();
            }
        }

        return false;
    }
}
