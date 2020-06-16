<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 14:37
 */

namespace App\Entity\Onboardings\UseCase\DeleteUserOnboarding;


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