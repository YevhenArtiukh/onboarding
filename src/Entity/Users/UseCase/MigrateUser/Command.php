<?php


namespace App\Entity\Users\UseCase\MigrateUser;


use App\Entity\Departments\Department;
use App\Entity\Users\User;

class Command
{
    private $user;
    private $department;
    private $position;
    private $formOfEmployment;
    private $typeOfWorker;
    private $email;
    private $responder;


    public function __construct(
        User $user,
        Department $department,
        string $position,
        string $formOfEmployment,
        string $typeOfWorker,
        string $email
    )
    {
        $this->user = $user;
        $this->department = $department;
        $this->position = $position;
        $this->formOfEmployment = $formOfEmployment;
        $this->typeOfWorker = $typeOfWorker;
        $this->email = $email;
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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