<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:21
 */

namespace App\Entity\Users\UseCase\CreateUser;


use App\Entity\Departments\Department;
use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $name;
    private $surname;
    private $email;
    private $department;
    private $identifier;
    private $dateOfEmployment;
    private $position;
    private $formOfEmployment;
    private $typeOfWorker;
    private $roles;
    private $responder;

    public function __construct(
        string $name,
        string $surname,
        string $email,
        Department $department,
        string $identifier,
        \DateTime $dateOfEmployment,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker,
        ArrayCollection $roles
    )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->department = $department;
        $this->identifier = $identifier;
        $this->dateOfEmployment = $dateOfEmployment;
        $this->position = $position;
        $this->formOfEmployment = $formOfEmployment;
        $this->typeOfWorker = $typeOfWorker;
        $this->roles = $roles;
        $this->responder = new NullResponder();
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
     * @return Department
     */
    public function getDepartment(): Department
    {
        return $this->department;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfEmployment(): \DateTime
    {
        return $this->dateOfEmployment;
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