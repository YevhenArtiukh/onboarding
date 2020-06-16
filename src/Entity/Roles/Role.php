<?php

namespace App\Entity\Roles;

use App\Entity\Emails\Email;
use App\Entity\Permissions\Permission;
use App\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Roles\RoleRepository")
 */
class Role
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Permissions\Permission", inversedBy="roles")
     */
    private $permissions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Users\User", mappedBy="roles")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users\User", mappedBy="currentRole")
     */
    private $currentUsers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Emails\Email", mappedBy="sentTo")
     */
    private $emails;

    public function __construct(
        string $name,
        ArrayCollection $permissions
    )
    {
        $this->name = $name;
        $this->permissions = $permissions;
        $this->users = new ArrayCollection();
        $this->currentUsers = new ArrayCollection();
        $this->emails = new ArrayCollection();
    }

    public function edit(
        string $name,
        PersistentCollection $permissions
    )
    {
        $this->name = $name;
        $this->permissions = $permissions;
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

    /**
     * @return Collection|Permission[]
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        if ($this->permissions->contains($permission)) {
            $this->permissions->removeElement($permission);
        }

        return $this;
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
            $user->addRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeRole($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getCurrentUsers(): Collection
    {
        return $this->currentUsers;
    }

    public function addCurrentUser(User $currentUser): self
    {
        if (!$this->currentUsers->contains($currentUser)) {
            $this->currentUsers[] = $currentUser;
            $currentUser->setCurrentRole($this);
        }

        return $this;
    }

    public function removeCurrentUser(User $currentUser): self
    {
        if ($this->currentUsers->contains($currentUser)) {
            $this->currentUsers->removeElement($currentUser);
            // set the owning side to null (unless already changed)
            if ($currentUser->getCurrentRole() === $this) {
                $currentUser->setCurrentRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Email[]
     */
    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function addEmail(Email $email): self
    {
        if (!$this->emails->contains($email)) {
            $this->emails[] = $email;
            $email->addSentTo($this);
        }

        return $this;
    }

    public function removeEmail(Email $email): self
    {
        if ($this->emails->contains($email)) {
            $this->emails->removeElement($email);
            $email->removeSentTo($this);
        }

        return $this;
    }
}
