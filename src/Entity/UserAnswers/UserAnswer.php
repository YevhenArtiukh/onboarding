<?php

namespace App\Entity\UserAnswers;

use App\Entity\UserResults\UserResult;
use App\Entity\Users\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAnswers\UserAnswerRepository")
 */
class UserAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User", inversedBy="userAnswers")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserResults\UserResult", inversedBy="userAnswers")
     */
    private $userResult;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $answer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $correct;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct(
        User $user,
        UserResult $userResult,
        string $question,
        string $answer,
        bool $correct
    )
    {
        $this->user = $user;
        $this->userResult = $userResult;
        $this->question = $question;
        $this->answer = $answer;
        $this->correct = $correct;
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserResult(): UserResult
    {
        return $this->userResult;
    }


    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
