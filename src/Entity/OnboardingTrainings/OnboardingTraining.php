<?php

namespace App\Entity\OnboardingTrainings;

use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining\Type;
use App\Entity\PresenceParticipants\PresenceParticipant;
use App\Entity\Trainings\Training;
use App\Entity\UserResults\UserResult;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\PersistentCollection;
use tidy;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OnboardingTrainings\OnboardingTrainingRepository")
 */
class OnboardingTraining
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Onboardings\Onboarding", inversedBy="onboardingTrainings")
     */
    private $onboarding;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trainings\Training", inversedBy="onboardingTrainings")
     */
    private $training;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Users\User", inversedBy="onboardingTrainingsCoach")
     * @JoinTable(name="onboarding_training_coach",
     *      joinColumns={@JoinColumn(name="onboarding_training_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $coaches;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     */
    private $day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Divisions\Division", inversedBy="onboardingTrainings")
     */
    private $division;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Users\User", mappedBy="onboardingTrainings")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserResults\UserResult", mappedBy="onboardingTraining")
     */
    private $userResults;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PresenceParticipants\PresenceParticipant", mappedBy="onboardingTraining")
     */
    private $presenceParticipants;

    public function __construct(
        Onboarding $onboarding,
        Training $training,
        ?Division $division,
        ?string $type,
        ?Collection $coaches,
        int $day,
        ?\DateTimeInterface $time = null
    )
    {
        $this->onboarding = $onboarding;
        $this->training = $training;
        $this->division = $division;
        $this->type = $type;
        $this->coaches = $coaches;
        $this->day = $day;
        $this->time = $time;
        $this->users = new ArrayCollection();
        $this->userResults = new ArrayCollection();
        $this->presenceParticipants = new ArrayCollection();
    }

    public function edit(
        Training $training,
        PersistentCollection $coaches,
        string $type,
        int $day,
        ?\DateTimeInterface $time = null
    )
    {
        $this->training = $training;
        $this->coaches = $coaches;
        $this->type = $type;
        $this->day = $day;
        $this->time = $time;
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

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function isTypeTest()
    {
        return $this->type === Type::TYPE_TEST;
    }

    public function isTypePresence()
    {
        return $this->type === Type::TYPE_PRESENCE;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getCoaches(): Collection
    {
        return $this->coaches;
    }

    public function addCoach(User $coach): self
    {
        if (!$this->coaches->contains($coach)) {
            $this->coaches[] = $coach;
        }

        return $this;
    }

    public function removeCoach(User $coach): self
    {
        if ($this->coaches->contains($coach)) {
            $this->coaches->removeElement($coach);
        }

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

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
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|UserResult[]
     */
    public function getUserResults(): Collection
    {
        return $this->userResults;
    }

    public function addUserResult(UserResult $userResult): self
    {
        if (!$this->userResults->contains($userResult)) {
            $this->userResults[] = $userResult;
            $userResult->setOnboardingTraining($this);
        }

        return $this;
    }

    public function removeUserResult(UserResult $userResult): self
    {
        if ($this->userResults->contains($userResult)) {
            $this->userResults->removeElement($userResult);
            // set the owning side to null (unless already changed)
            if ($userResult->getOnboardingTraining() === $this) {
                $userResult->setOnboardingTraining(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PresenceParticipant[]
     */
    public function getPresenceParticipants(): Collection
    {
        return $this->presenceParticipants;
    }

    public function addPresenceParticipant(PresenceParticipant $presenceParticipant): self
    {
        if (!$this->presenceParticipants->contains($presenceParticipant)) {
            $this->presenceParticipants[] = $presenceParticipant;
            $presenceParticipant->setOnboardingTraining($this);
        }

        return $this;
    }

    public function removePresenceParticipant(PresenceParticipant $presenceParticipant): self
    {
        if ($this->presenceParticipants->contains($presenceParticipant)) {
            $this->presenceParticipants->removeElement($presenceParticipant);
            // set the owning side to null (unless already changed)
            if ($presenceParticipant->getOnboardingTraining() === $this) {
                $presenceParticipant->setOnboardingTraining(null);
            }
        }

        return $this;
    }
}
