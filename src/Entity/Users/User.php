<?php

namespace App\Entity\Users;

use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Onboardings\Onboarding;
use App\Entity\PresenceParticipants\PresenceParticipant;
use App\Entity\Roles\Role;
use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire;
use App\Entity\UserAnswers\UserAnswer;
use App\Entity\UserOnboardingTrainings\UserOnboardingTraining;
use App\Entity\UserResults\UserResult;
use App\Entity\UserTrainings\UserTraining;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Users\UserRepository")
 */
class User implements UserInterface
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
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $formOfEmployment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfWorker;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Roles\Role", inversedBy="users")
     */
    private $roles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles\Role", inversedBy="currentUsers")
     */
    private $currentRole;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfEmployment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $block;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departments\Department", inversedBy="users")
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tokenLife;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Departments\Department", mappedBy="manager")
     */
    private $departmentsManager;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\OnboardingTrainings\OnboardingTraining", mappedBy="coaches")
     * @JoinTable(name="onboarding_training_coach",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="onboarding_training_id", referencedColumnName="id")}
     *      )
     */
    private $onboardingTrainingsCoach;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Onboardings\Onboarding", inversedBy="users")
     * @ORM\JoinColumn(name="onboarding_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $onboarding;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\OnboardingTrainings\OnboardingTraining", inversedBy="users")
     */
    private $onboardingTrainings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Departments\Department", mappedBy="businessPartner")
     */
    private $departmentsBusinessPartner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAnswers\UserAnswer", mappedBy="user")
     */
    private $userAnswers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserResults\UserResult", mappedBy="user")
     */
    private $userResults;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire", mappedBy="user")
     */
    private $userAnswerQuestionnaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PresenceParticipants\PresenceParticipant", mappedBy="user")
     */
    private $presenceParticipantsUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PresenceParticipants\PresenceParticipant", mappedBy="coach")
     */
    private $presenceParticipantsCoach;

    public function __construct(
        string $name,
        string $surname,
        string $email,
        Department $department,
        ?string $identifier,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker,
        ArrayCollection $roles,
        string $login,
        string $password,
        ?Onboarding $onboarding,
        ArrayCollection $onboardingTrainings,
        DateTime $dateOfEmployment = null
    )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->department = $department;
        $this->identifier = $identifier;
        $this->position = $position;
        $this->formOfEmployment = $formOfEmployment;
        $this->typeOfWorker = $typeOfWorker;
        $this->roles = $roles;
        $this->login = $login;
        $this->password = $password;
        $this->onboarding = $onboarding;
        $this->active = false;
        $this->block = false;
        $this->departmentsManager = new ArrayCollection();
        $this->onboardingTrainingsCoach = new ArrayCollection();
        $this->onboardingTrainings = $onboardingTrainings;
        $this->departmentsBusinessPartner = new ArrayCollection();
        $this->dateOfEmployment = $dateOfEmployment??new DateTime('now');
		$this->userAnswers = new ArrayCollection();
        $this->userResults = new ArrayCollection();
        $this->userAnswerQuestionnaires = new ArrayCollection();
        $this->presenceParticipantsUser = new ArrayCollection();
        $this->presenceParticipantsCoach = new ArrayCollection();
    }

    public function firstLogin(
        string $password,
        Role $role
    )
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->currentRole = $role;
        $this->active = true;
    }

    public function passwordReset(
        string $token
    )
    {
        $this->token = $token;
        $this->tokenLife = date_modify(new \DateTime(), '+30 minutes');
    }

    public function passwordResetChange(
        string $password
    )
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->token = null;
        $this->tokenLife = null;
    }

    public function edit(
        string $name,
        string $surname,
        string $email,
        ?string $identifier,
        Department $department,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker,
        Collection $roles,
        DateTime $dateOfEmployment
    )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->identifier = $identifier;
        $this->department = $department;
        $this->position = $position;
        $this->formOfEmployment = $formOfEmployment;
        $this->typeOfWorker = $typeOfWorker;
        $this->roles = $roles;
        $this->dateOfEmployment = $dateOfEmployment;
    }

    public function migrate(
        string $email,
        Department $department,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker
    )
    {
        $this->email = $email;
        $this->department = $department;
        $this->position = $position;
        $this->formOfEmployment = $formOfEmployment;
        $this->typeOfWorker = $typeOfWorker;
    }


    public function blockUser(bool $block)
    {
        $this->block = $block;
    }

    public function anonymization()
    {
        $this->name = '****';
        $this->surname = '****';
        $this->email = '****';
        $this->login = '****';
        $this->identifier = '****';
        $this->photo = null;
        $this->block = true;
    }

    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getFormOfEmployment(): ?string
    {
        return $this->formOfEmployment;
    }

    public function setFormOfEmployment(string $formOfEmployment): self
    {
        $this->formOfEmployment = $formOfEmployment;

        return $this;
    }

    public function getTypeOfWorker(): ?string
    {
        return $this->typeOfWorker;
    }

    public function setTypeOfWorker(string $typeOfWorker): self
    {
        $this->typeOfWorker = $typeOfWorker;

        return $this;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    public function getCurrentRole(): ?Role
    {
        return $this->currentRole;
    }

    public function setCurrentRole(?Role $currentRole): self
    {
        $this->currentRole = $currentRole;

        return $this;
    }

    public function getDateOfEmployment(): ?\DateTime
    {
        return $this->dateOfEmployment;
    }

    public function setDateOfEmployment(\DateTimeInterface $dateOfEmployment): self
    {
        $this->dateOfEmployment = $dateOfEmployment;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        $roleArray = [];
        foreach ($this->roles as $role) {
            $roleArray[] = $role->getName();
        }

        return $roleArray;
    }

    public function getRolesEntity()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getLogin();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBlock(): bool
    {
        return $this->block;
    }


    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTokenLife(): ?\DateTimeInterface
    {
        return $this->tokenLife;
    }

    public function setTokenLife(?\DateTimeInterface $tokenLife): self
    {
        $this->tokenLife = $tokenLife;

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartmentsManager(): Collection
    {
        return $this->departmentsManager;
    }

    public function addDepartmentManager(Department $department): self
    {
        if (!$this->departmentsManager->contains($department)) {
            $this->departmentsManager[] = $department;
            $department->setManager($this);
        }

        return $this;
    }

    public function removeDepartmentManager(Department $department): self
    {
        if ($this->departmentsManager->contains($department)) {
            $this->departmentsManager->removeElement($department);
            // set the owning side to null (unless already changed)
            if ($department->getManager() === $this) {
                $department->setManager(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OnboardingTraining[]
     */
    public function getOnboardingTrainingsCoach(): Collection
    {
        return $this->onboardingTrainingsCoach;
    }

    public function addOnboardingTrainingCoach(OnboardingTraining $onboardingTraining): self
    {
        if (!$this->onboardingTrainingsCoach->contains($onboardingTraining)) {
            $this->onboardingTrainingsCoach[] = $onboardingTraining;
            $onboardingTraining->addCoach($this);
        }

        return $this;
    }

    public function removeOnboardingTrainingCoach(OnboardingTraining $onboardingTraining): self
    {
        if ($this->onboardingTrainingsCoach->contains($onboardingTraining)) {
            $this->onboardingTrainingsCoach->removeElement($onboardingTraining);
            $onboardingTraining->removeCoach($this);
        }

        return $this;
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

    /**
     * @return Collection|OnboardingTraining[]
     */
    public function getOnboardingTrainings(): Collection
    {
        return $this->onboardingTrainings;
    }

    public function editOnboardingTrainings(ArrayCollection $onboardingTrainings): self
    {
        $this->onboardingTrainings = $onboardingTrainings;

        return $this;
    }

    public function addOnboardingTraining(OnboardingTraining $onboardingTraining): self
    {
        if (!$this->onboardingTrainings->contains($onboardingTraining)) {
            $this->onboardingTrainings[] = $onboardingTraining;
            $onboardingTraining->addUser($this);
        }

        return $this;
    }

    public function removeOnboardingTraining(OnboardingTraining $onboardingTraining): self
    {
        if ($this->onboardingTrainings->contains($onboardingTraining)) {
            $this->onboardingTrainings->removeElement($onboardingTraining);
            $onboardingTraining->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartmentsBusinessPartner(): Collection
    {
        return $this->departmentsBusinessPartner;
    }

    public function addDepartmentBusinessPartner(Department $departmentsBusinessPartner): self
    {
        if (!$this->departmentsBusinessPartner->contains($departmentsBusinessPartner)) {
            $this->departmentsBusinessPartner[] = $departmentsBusinessPartner;
            $departmentsBusinessPartner->setBusinessPartner($this);
        }

        return $this;
    }

    public function removeDepartmentBusinessPartner(Department $departmentsBusinessPartner): self
    {
        if ($this->departmentsBusinessPartner->contains($departmentsBusinessPartner)) {
            $this->departmentsBusinessPartner->removeElement($departmentsBusinessPartner);
            // set the owning side to null (unless already changed)
            if ($departmentsBusinessPartner->getBusinessPartner() === $this) {
                $departmentsBusinessPartner->setBusinessPartner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserAnswer[]
     */
    public function getUserAnswers(): Collection
    {
        return $this->userAnswers;
    }

    public function addUserAnswer(UserAnswer $userAnswer): self
    {
        if (!$this->userAnswers->contains($userAnswer)) {
            $this->userAnswers[] = $userAnswer;
            $userAnswer->setUser($this);
        }

        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): self
    {
        if ($this->userAnswers->contains($userAnswer)) {
            $this->userAnswers->removeElement($userAnswer);
            // set the owning side to null (unless already changed)
            if ($userAnswer->getUser() === $this) {
                $userAnswer->setUser(null);
            }
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
            $userResult->setUser($this);
        }

        return $this;
    }

    public function removeUserResult(UserResult $userResult): self
    {
        if ($this->userResults->contains($userResult)) {
            $this->userResults->removeElement($userResult);
            // set the owning side to null (unless already changed)
            if ($userResult->getUser() === $this) {
                $userResult->setUser(null);
            }
        }

        return $this;
    }

    public function getOnboardingDate()
    {
        if($this->getOnboarding())
            return $this->getOnboarding()->getDays()[0]['day'];
        return null;
    }

    public function getDepartmentManagerName()
    {
        if ($this->getDepartment()->getManager())
            return $this->getDepartment()->getManager()->getName();
        return null;
    }

    public function getDepartmentManagerSurname()
    {
        if ($this->getDepartment()->getManager())
            return $this->getDepartment()->getManager()->getSurname();
        return null;
    }

    public function getDepartmentManagerEmail()
    {
        if ($this->getDepartment()->getManager())
            return $this->getDepartment()->getManager()->getEmail();
        return null;
    }

    public function getHRName()
    {
        if ($this->getDepartment()->getBusinessPartner())
            return $this->getDepartment()->getBusinessPartner()->getName();
        return null;
    }

    public function getHRSurname()
    {
        if ($this->getDepartment()->getBusinessPartner())
            return $this->getDepartment()->getBusinessPartner()->getSurname();
        return null;
    }

    public function getHREmail()
    {
        if ($this->getDepartment()->getBusinessPartner())
            return $this->getDepartment()->getBusinessPartner()->getEmail();
        return null;
    }

    public function activeString()
    {
        return $this->active?'Aktywny':'Zablokowany';
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
            $userAnswerQuestionnaire->setUser($this);
        }

        return $this;
    }

    public function removeUserAnswerQuestionnaire(UserAnswerQuestionnaire $userAnswerQuestionnaire): self
    {
        if ($this->userAnswerQuestionnaires->contains($userAnswerQuestionnaire)) {
            $this->userAnswerQuestionnaires->removeElement($userAnswerQuestionnaire);
            // set the owning side to null (unless already changed)
            if ($userAnswerQuestionnaire->getUser() === $this) {
                $userAnswerQuestionnaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PresenceParticipant[]
     */
    public function getPresenceParticipantsUser(): Collection
    {
        return $this->presenceParticipantsUser;
    }

    public function addPresenceParticipantsUser(PresenceParticipant $presenceParticipantsUser): self
    {
        if (!$this->presenceParticipantsUser->contains($presenceParticipantsUser)) {
            $this->presenceParticipantsUser[] = $presenceParticipantsUser;
            $presenceParticipantsUser->setUser($this);
        }

        return $this;
    }

    public function removePresenceParticipantsUser(PresenceParticipant $presenceParticipantsUser): self
    {
        if ($this->presenceParticipantsUser->contains($presenceParticipantsUser)) {
            $this->presenceParticipantsUser->removeElement($presenceParticipantsUser);
            // set the owning side to null (unless already changed)
            if ($presenceParticipantsUser->getUser() === $this) {
                $presenceParticipantsUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PresenceParticipant[]
     */
    public function getPresenceParticipantsCoach(): Collection
    {
        return $this->presenceParticipantsCoach;
    }

    public function addPresenceParticipantsCoach(PresenceParticipant $presenceParticipantsCoach): self
    {
        if (!$this->presenceParticipantsCoach->contains($presenceParticipantsCoach)) {
            $this->presenceParticipantsCoach[] = $presenceParticipantsCoach;
            $presenceParticipantsCoach->setCoach($this);
        }

        return $this;
    }

    public function removePresenceParticipantsCoach(PresenceParticipant $presenceParticipantsCoach): self
    {
        if ($this->presenceParticipantsCoach->contains($presenceParticipantsCoach)) {
            $this->presenceParticipantsCoach->removeElement($presenceParticipantsCoach);
            // set the owning side to null (unless already changed)
            if ($presenceParticipantsCoach->getCoach() === $this) {
                $presenceParticipantsCoach->setCoach(null);
            }
        }

        return $this;
    }

}
