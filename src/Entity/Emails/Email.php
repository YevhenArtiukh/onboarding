<?php

namespace App\Entity\Emails;

use App\Entity\Roles\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Emails\EmailRepository")
 */
class Email
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
    private $category;

    /**
     * @ORM\Column(type="array")
     */
    private $days;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $function;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Roles\Role", inversedBy="emails")
     */
    private $sentTo;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="array")
     */
    private $variables;

    public function __construct(
        string $name,
        string $category,
        array $days,
        string $function,
        ArrayCollection $sentTo,
        string $message,
        array $variables
    )
    {
        $this->name = $name;
        $this->category = $category;
        $this->days = $days;
        $this->function = $function;
        $this->sentTo = $sentTo;
        $this->message = $message;
        $this->variables = $variables;
    }

    public function edit(
        string $name,
        array $days,
        $sentTo,
        string $message
    )
    {
        $this->name = $name;
        $this->days = $days;
        $this->sentTo = $sentTo;
        $this->message = $message;
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDays(): array
    {
        return $this->days;
    }

    public function setDays(array $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(string $function): self
    {
        $this->function = $function;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getVariables(): ?array
    {
        return $this->variables;
    }

    public function setVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getSentTo(): Collection
    {
        return $this->sentTo;
    }

    public function addSentTo(Role $sentTo): self
    {
        if (!$this->sentTo->contains($sentTo)) {
            $this->sentTo[] = $sentTo;
        }

        return $this;
    }

    public function removeSentTo(Role $sentTo): self
    {
        if ($this->sentTo->contains($sentTo)) {
            $this->sentTo->removeElement($sentTo);
        }

        return $this;
    }
}
