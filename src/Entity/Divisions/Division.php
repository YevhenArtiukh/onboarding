<?php

namespace App\Entity\Divisions;

use App\Entity\Departments\Department;
use App\Entity\OnboardingDivisions\OnboardingDivision;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Trainings\Training;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Divisions\DivisionRepository")
 */
class Division
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Departments\Department", mappedBy="division")
     */
    private $departments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trainings\Training", mappedBy="divisions")
     */
    private $trainings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OnboardingDivisions\OnboardingDivision", mappedBy="division")
     */
    private $onboardingDivisions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OnboardingTrainings\OnboardingTraining", mappedBy="division")
     */
    private $onboardingTrainings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $messageEmail;

    public function __construct(
        string $name,
        ?string $messageEmail
    )
    {
        $this->name = $name;
        $this->messageEmail = $messageEmail;
        $this->departments = new ArrayCollection();
        $this->trainings = new ArrayCollection();
        $this->onboardingDivisions = new ArrayCollection();
        $this->onboardingTrainings = new ArrayCollection();
    }

    public function edit(
        string $name,
        ?string $messageEmail
    )
    {
        $this->name = $name;
        $this->messageEmail = $messageEmail;
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->setDivision($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
            // set the owning side to null (unless already changed)
            if ($department->getDivision() === $this) {
                $department->setDivision(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->addDivision($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->contains($training)) {
            $this->trainings->removeElement($training);
            $training->removeDivision($this);
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
            $onboardingDivision->setDivision($this);
        }

        return $this;
    }

    public function removeOnboardingDivision(OnboardingDivision $onboardingDivision): self
    {
        if ($this->onboardingDivisions->contains($onboardingDivision)) {
            $this->onboardingDivisions->removeElement($onboardingDivision);
            // set the owning side to null (unless already changed)
            if ($onboardingDivision->getDivision() === $this) {
                $onboardingDivision->setDivision(null);
            }
        }

        return $this;
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
            $onboardingTraining->setDivision($this);
        }

        return $this;
    }

    public function removeOnboardingTraining(OnboardingTraining $onboardingTraining): self
    {
        if ($this->onboardingTrainings->contains($onboardingTraining)) {
            $this->onboardingTrainings->removeElement($onboardingTraining);
            // set the owning side to null (unless already changed)
            if ($onboardingTraining->getDivision() === $this) {
                $onboardingTraining->setDivision(null);
            }
        }

        return $this;
    }

    public function getMessageEmail(): ?string
    {
        return $this->messageEmail;
    }

    public function setMessageEmail(?string $messageEmail): self
    {
        $this->messageEmail = $messageEmail;

        return $this;
    }
}
