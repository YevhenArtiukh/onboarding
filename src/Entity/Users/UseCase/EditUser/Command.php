<?php


namespace App\Entity\Users\UseCase\EditUser;


use App\Entity\Departments\Department;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class Command
{
    private $user;
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
        User $user,
        string $name,
        string $surname,
        string $email,
        Department $department,
        string $identifier,
        \DateTime $dateOfEmployment,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker,
        PersistentCollection $roles
    )
    {
        $this->user = $user;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
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
    public function getRoles(): PersistentCollection
    {
        return $this->roles;
    }

    /**
     * @return Responder
     */
    public function getResponder(): Responder
    {
        return $this->responder;
    }

    /**
     * @param Responder $responder
     */
    public function setResponder(Responder $responder): void
    {
        $this->responder = $responder;
    }


}