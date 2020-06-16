<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 14:44
 */

namespace App\Entity\Onboardings\UseCase\AddUserOnboarding;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $onboarding;
    private $division;
    private $name;
    private $surname;
    private $email;
    private $identifier;
    private $department;
    private $position;
    private $formOfEmployment;
    private $typeOfWorker;
    private $roles;
    private $responder;

    public function __construct(
        Onboarding $onboarding,
        Division $division,
        string $name,
        string $surname,
        string $email,
        ?string $identifier,
        Department $department,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker,
        ArrayCollection $roles
    )
    {
        $this->onboarding = $onboarding;
        $this->division = $division;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->identifier = $identifier;
        $this->department = $department;
        $this->position = $position;
        $this->formOfEmployment = $formOfEmployment;
        $this->typeOfWorker = $typeOfWorker;
        $this->roles = $roles;
        $this->responder = new NullResponder();
    }

    /**
     * @return Onboarding
     */
    public function getOnboarding(): Onboarding
    {
        return $this->onboarding;
    }

    /**
     * @return Division
     */
    public function getDivision(): Division
    {
        return $this->division;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @return Department
     */
    public function getDepartment(): Department
    {
        return $this->department;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getFormOfEmployment(): string
    {
        return $this->formOfEmployment;
    }

    /**
     * @return string
     */
    public function getTypeOfWorker(): string
    {
        return $this->typeOfWorker;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles(): ArrayCollection
    {
        return $this->roles;
    }

    public function getResponder(): Responder
    {
        return $this->responder;
    }

    public function setResponder(Responder $responder): self
    {
        $this->responder = $responder;

        return $this;
    }
}