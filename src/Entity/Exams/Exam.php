<?php

namespace App\Entity\Exams;

use App\Entity\Exams\Exam\Type;
use App\Entity\Questions\Question;
use App\Entity\Trainings\Training;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Exams\ExamRepository")
 */
class Exam
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
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trainings\Training", inversedBy="exams")
     */
    private $training;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Questions\Question", mappedBy="exam", cascade={"remove"})
     */
    private $questions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOfModification;

    public function __construct(
        string $name,
        string $type,
        int $duration,
        bool $isActive,
        Training $training
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->duration = $duration;
        $this->isActive = $isActive;
        $this->training = $training;
        $this->dateOfModification = new \DateTime('now');
        $this->questions = new ArrayCollection();
    }

    public function edit(
        string $name,
        int $duration,
        bool $isActive
    ){
        $this->name = $name;
        $this->duration = $duration;
        $this->isActive = $isActive;
        $this->dateOfModification = new \DateTime('now');
    }

    public function changeActive()
    {
        $this->isActive = false;
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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

    public function isTest(): bool
    {
        return $this->type === Type::TYPE_TEST;
    }

    public function isAnkieta(): bool
    {
        return $this->type === Type::TYPE_ANKIETA;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setExam($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getExam() === $this) {
                $question->setExam(null);
            }
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfModification(): \DateTime
    {
        return $this->dateOfModification;
    }

}
