<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:08
 */

namespace App\Entity\Roles\UseCase\CreateRole;


use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $name;
    private $permissions;
    private $responder;

    public function __construct(
        string $name,
        ArrayCollection $permissions
    )
    {
        $this->name = $name;
        $this->permissions = $permissions;
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
     * @return ArrayCollection
     */
    public function getPermissions(): ArrayCollection
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