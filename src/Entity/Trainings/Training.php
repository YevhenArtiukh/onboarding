<?php

namespace App\Entity\Trainings;

use App\Entity\Divisions\Division;
use App\Entity\Exams\Exam;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\TrainingAttachments\TrainingAttachment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Trainings\TrainingRepository")
 */
class Training
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
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfTraining;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Divisions\Division", inversedBy="trainings")
     */
    private $divisions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingAttachments\TrainingAttachment", mappedBy="Training")
     */
    private $trainingAttachments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exams\Exam", mappedBy="training")
     */
    private $exams;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $kindOfTraining;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $trainerInfo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $workerInfo;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAdditional;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OnboardingTrainings\OnboardingTraining", mappedBy="training")
     */
    private $onboardingTrainings;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEvaluationSurvey;

    public function __construct(
        string $name,
        int $time,
        string $typeOfTraining,
        string $kindOfTraining,
        ?string $description,
        ?string $trainerInfo,
        ?string $workerInfo,
        bool $isAdditional,
        ArrayCollection $divisions
    )
    {
        $this->name = $name;
        $this->time = $time;
        $this->typeOfTraining = $typeOfTraining;
        $this->kindOfTraining = $kindOfTraining;
        $this->description = $description;
        $this->trainerInfo = $trainerInfo;
        $this->workerInfo = $workerInfo;
        $this->isAdditional = $isAdditional;
        $this->divisions = $divisions;
        $this->onboardings = new ArrayCollection();
        $this->trainingAttachments = new ArrayCollection();
        $this->exams = new ArrayCollection();
        $this->onboardingTrainings = new ArrayCollection();
        $this->isEvaluationSurvey = false;
    }

    public function edit(
        string $name,
        int $time,
        string $typeOfTraining,
        string $kindOfTraining,
        ?string $description,
        ?string $trainerInfo,
        ?string $workerInfo,
        bool $isAdditional,
        $divisions
    )
    {
        $this->name = $name;
        $this->time = $time;
        $this->typeOfTraining = $typeOfTraining;
        $this->kindOfTraining = $kindOfTraining;
        $this->description = $description;
        $this->trainerInfo = $trainerInfo;
        $this->workerInfo = $workerInfo;
        $this->isAdditional = $isAdditional;
        $this->divisions = $divisions;
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

    public function getTypeOfTraining(): ?string
    {
        return $this->typeOfTraining;
    }

    public function setTypeOfTraining(string $typeOfTraining): self
    {
        $this->typeOfTraining = $typeOfTraining;

        return $this;
    }

    /**
     * @return Collection|Division[]
     */
    public function getDivisions(): Collection
    {
        return $this->divisions;
    }

    public function addDivision(Division $division): self
    {
        if (!$this->divisions->contains($division)) {
            $this->divisions[] = $division;
        }

        return $this;
    }

    public function removeDivision(Division $division): self
    {
        if ($this->divisions->contains($division)) {
            $this->divisions->removeElement($division);
        }

        return $this;
    }

    /**
     * @return Collection|TrainingAttachment[]
     */
    public function getTrainingAttachments(): Collection
    {
        return $this->trainingAttachments;
    }

    public function addTrainingAttachment(TrainingAttachment $trainingAttachment): self
    {
        if (!$this->trainingAttachments->contains($trainingAttachment)) {
            $this->trainingAttachments[] = $trainingAttachment;
            $trainingAttachment->setTraining($this);
        }

        return $this;
    }

    public function removeTrainingAttachment(TrainingAttachment $trainingAttachment): self
    {
        if ($this->trainingAttachments->contains($trainingAttachment)) {
            $this->trainingAttachments->removeElement($trainingAttachment);
            // set the owning side to null (unless already changed)
            if ($trainingAttachment->getTraining() === $this) {
                $trainingAttachment->setTraining(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Exam[]
     */
    public function getExams(): Collection
    {
        return $this->exams;
    }

    public function addExam(Exam $exam): self
    {
        if (!$this->exams->contains($exam)) {
            $this->exams[] = $exam;
            $exam->setTraining($this);
        }

        return $this;
    }

    public function removeExam(Exam $exam): self
    {
        if ($this->exams->contains($exam)) {
            $this->exams->removeElement($exam);
            // set the owning side to null (unless already changed)
            if ($exam->getTraining() === $this) {
                $exam->setTraining(null);
            }
        }

        return $this;
    }

    public function getKindOfTraining(): ?string
    {
        return $this->kindOfTraining;
    }

    public function setKindOfTraining(string $kindOfTraining): self
    {
        $this->kindOfTraining = $kindOfTraining;

        return $this;
    }

    public function isGeneral()
    {
        return $this->kindOfTraining === 'general';
    }

    public function isDivision()
    {
        return $this->kindOfTraining === 'division';
    }

    public function getTrainerInfo(): ?string
    {
        return $this->trainerInfo;
    }

    public function setTrainerInfo(?string $trainerInfo): self
    {
        $this->trainerInfo = $trainerInfo;

        return $this;
    }

    public function getWorkerInfo(): ?string
    {
        return $this->workerInfo;
    }

    public function setWorkerInfo(?string $workerInfo): self
    {
        $this->workerInfo = $workerInfo;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getIsAdditional(): ?bool
    {
        return $this->isAdditional;
    }

    public function setIsAdditional(bool $isAdditional): self
    {
        $this->isAdditional = $isAdditional;

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
            $onboardingTraining->setTraining($this);
        }

        return $this;
    }

    public function removeOnboardingTraining(OnboardingTraining $onboardingTraining): self
    {
        if ($this->onboardingTrainings->contains($onboardingTraining)) {
            $this->onboardingTrainings->removeElement($onboardingTraining);
            // set the owning side to null (unless already changed)
            if ($onboardingTraining->getTraining() === $this) {
                $onboardingTraining->setTraining(null);
            }
        }

        return $this;
    }
}
