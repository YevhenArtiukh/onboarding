<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 14:49
 */

namespace App\Entity\Users\UseCase\DeleteUser;


use App\Entity\Users\User;

class Command
{
    private $user;
    private $responder;

    public function __construct(
        User $user
    )
    {
        $this->user = $user;
        $this->responder = new NullResponder();
    }

    /**
     * @return User
     */
    public function getUser(): User
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