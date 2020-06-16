<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-16
 * Time: 11:55
 */

namespace App\Entity\Onboardings\UseCase\EditUserOnboarding;


use App\Entity\Departments\Department;
use Doctrine\ORM\PersistentCollection;

class Command
{
    private $id;
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
        int $id,
        string $name,
        string $surname,
        string $email,
        ?string $identifier,
        Department $department,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker,
        PersistentCollection $roles
    )
    {
        $this->id = $id;
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return null|string
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
     * @return PersistentCollection
     */
    public function getRoles(): PersistentCollection
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