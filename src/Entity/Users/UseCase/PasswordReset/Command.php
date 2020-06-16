<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 9:50
 */

namespace App\Entity\Users\UseCase\PasswordReset;


class Command
{
    private $email;
    private $responder;

    public function __construct(
        string $email
    )
    {
        $this->email = $email;
        $this->responder = new NullResponder();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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