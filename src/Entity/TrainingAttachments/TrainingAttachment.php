<?php

namespace App\Entity\TrainingAttachments;

use App\Entity\Trainings\Training;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingAttachments\TrainingAttachmentRepository")
 */
class TrainingAttachment
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
    private $defaultName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trainings\Training", inversedBy="trainingAttachments")
     */
    private $Training;


    public function __construct(
        string $defaultName,
        Training $Training
    )
    {
        $this->defaultName = $defaultName;
        $this->Training = $Training;
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

    public function getDefaultName(): ?string
    {
        return $this->defaultName;
    }

    public function setDefaultName(string $defaultName): self
    {
        $this->defaultName = $defaultName;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->Training;
    }

    public function setTraining(?Training $Training): self
    {
        $this->Training = $Training;

        return $this;
    }
}
