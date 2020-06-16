<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-25
 * Time: 14:07
 */

namespace App\Entity\Departments\UseCase\EditDepartment;


use App\Entity\Departments\Department;
use App\Entity\Users\User;

class Command
{
    private $id;
    private $name;
    private $parent;
    private $manager;
    private $businessPartner;
    private $responder;

    public function __construct(
        int $id,
        string $name,
        ?Department $parent,
        ?User $manager,
        ?User $businessPartner
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent = $parent;
        $this->manager = $manager;
        $this->businessPartner = $businessPartner;
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
     * @return Department|null
     */
    public function getParent(): ?Department
    {
        return $this->parent;
    }

    /**
     * @return User|null
     */
    public function getManager(): ?User
    {
        return $this->manager;
    }

    /**
     * @return User|null
     */
    public function getBusinessPartner(): ?User
    {
        return $this->businessPartner;
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