<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 12:39
 */

namespace App\Entity\Users\UseCase\EditCurrentRole;

use Symfony\Component\Security\Core\User\UserInterface;

class Command
{
    private $name;
    private $user;
    private $responder;

    public function __construct(
        string $name,
        UserInterface $user
    )
    {
        $this->name = $name;
        $this->user = $user;
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
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
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