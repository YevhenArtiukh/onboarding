<?php

namespace App\Entity\Departments;

use App\Entity\Divisions\Division;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Departments\DepartmentRepository")
 */
class Department
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Divisions\Division", inversedBy="departments")
     */
    private $division;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Departments\Department", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departments\Department", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users\User", mappedBy="department")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User", inversedBy="departmentsManager")
     */
    private $manager;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User", inversedBy="departmentsBusinessPartner")
     */
    private $businessPartner;

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
        $this->children = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function edit(
        string $name,
        ?Department $parent,
        ?User $manager,
        ?User $businessPartner
    )
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->manager = $manager;
        $this->businessPartner = $businessPartner;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDivision(): ?Division
    {
        return $this->division;
    }

    public function setDivision(?Division $division): self
    {
        $this->division = $division;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function __toArray()
    {
        return [
            'name' => $this->getName()
        ];
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setDepartment($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getDepartment() === $this) {
                $user->setDepartment(null);
            }
        }

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getBusinessPartner(): ?User
    {
        return $this->businessPartner;
    }

    public function setBusinessPartner(?User $businessPartner): self
    {
        $this->businessPartner = $businessPartner;

        return $this;
    }
}
