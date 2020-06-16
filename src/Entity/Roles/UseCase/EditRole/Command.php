<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:25
 */

namespace App\Entity\Roles\UseCase\EditRole;


use Doctrine\ORM\PersistentCollection;

class Command
{
    private $id;
    private $name;
    private $permissions;
    private $responder;

    public function __construct(
        int $id,
        string $name,
        PersistentCollection $permissions
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->permissions = $permissions;
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
     * @return PersistentCollection
     */
    public function getPermissions(): PersistentCollection
    {
        return $this->permissions;
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