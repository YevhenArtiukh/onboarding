<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 18:05
 */

namespace App\Entity\Departments\UseCase\CreateDepartment;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use App\Entity\Users\User;
use Symfony\Component\Security\Core\User\UserInterface;

class Command
{
    private $name;
    private $parent;
    private $manager;
    private $businessPartner;
    private $division;
    private $responder;

    public function __construct(
        string $name,
        ?Department $parent,
        ?User $manager,
        ?User $businessPartner,
        ?Division $division
    )
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->manager = $manager;
        $this->businessPartner = $businessPartner;
        $this->division = $division;
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

    /**
     * @return Division|null
     */
    public function getDivision(): ?Division
    {
        return $this->division;
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