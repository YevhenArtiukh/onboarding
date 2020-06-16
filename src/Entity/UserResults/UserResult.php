<?php

namespace App\Entity\UserResults;

use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserResults\UserResultRepository")
 */
class UserResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User", inversedBy="userResults")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OnboardingTrainings\OnboardingTraining", inversedBy="userResults")
     */
    private $onboardingTraining;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAnswers\UserAnswer", mappedBy="userResult")
     */
    private $userAnswers;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire", mappedBy="userResult")
     */
    private $userAnswerQuestionnaires;

    public function __construct(
        User $user,
        OnboardingTraining $onboardingTraining,
        int $score
    )
    {
        $this->user = $user;
        $this->onboardingTraining = $onboardingTraining;
        $this->score = $score;
        $this->userAnswers = new ArrayCollection();
        $this->date = new \DateTime();
        $this->userAnswerQuestionnaires = new ArrayCollection();
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

    public function getOnboardingTraining(): ?OnboardingTraining
    {
        return $this->onboardingTraining;
    }

    public function setOnboardingTraining(?OnboardingTraining $onboardingTraining): self
    {
        $this->onboardingTraining = $onboardingTraining;

        return $this;
    }

    public function getUserAnswers(): ArrayCollection
    {
        return $this->userAnswers;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

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

    /**
     * @return Collection|UserAnswerQuestionnaire[]
     */
    public function getUserAnswerQuestionnaires(): Collection
    {
        return $this->userAnswerQuestionnaires;
    }

    public function addUserAnswerQuestionnaire(UserAnswerQuestionnaire $userAnswerQuestionnaire): self
    {
        if (!$this->userAnswerQuestionnaires->contains($userAnswerQuestionnaire)) {
            $this->userAnswerQuestionnaires[] = $userAnswerQuestionnaire;
            $userAnswerQuestionnaire->setUserResult($this);
        }

        return $this;
    }

    public function removeUserAnswerQuestionnaire(UserAnswerQuestionnaire $userAnswerQuestionnaire): self
    {
        if ($this->userAnswerQuestionnaires->contains($userAnswerQuestionnaire)) {
            $this->userAnswerQuestionnaires->removeElement($userAnswerQuestionnaire);
            // set the owning side to null (unless already changed)
            if ($userAnswerQuestionnaire->getUserResult() === $this) {
                $userAnswerQuestionnaire->setUserResult(null);
            }
        }

        return $this;
    }
}
