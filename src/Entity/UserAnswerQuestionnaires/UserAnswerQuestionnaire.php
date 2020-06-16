<?php

namespace App\Entity\UserAnswerQuestionnaires;

use App\Entity\UserResults\UserResult;
use App\Entity\Users\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAnswerQuestionnaires\UserAnswerQuestionnaireRepository")
 */
class UserAnswerQuestionnaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User", inversedBy="userAnswerQuestionnaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserResults\UserResult", inversedBy="userAnswerQuestionnaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userResult;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $questionType;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="array")
     */
    private $answers = [];


    public function __construct(
        User $user,
        UserResult $userResult,
        string $question,
        string $questionType,
        array $answers
    )
    {
        $this->user = $user;
        $this->userResult = $userResult;
        $this->question = $question;
        $this->questionType = $questionType;
        $this->date = new \DateTime();
        $this->answers = $answers;
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

    public function getUserResult(): ?UserResult
    {
        return $this->userResult;
    }

    public function setUserResult(?UserResult $userResult): self
    {
        $this->userResult = $userResult;

        return $this;
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

    public function getQuestionType()
    {
        return $this->questionType;
    }

    public function setQuestionType(string $questionType): self
    {
        $this->questionType = $questionType;

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

    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): self
    {
        $this->answers = $answers;

        return $this;
    }
}
