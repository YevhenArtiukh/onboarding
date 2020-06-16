<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 11:16
 */

namespace App\Entity\Users\UseCase\PasswordResetChange;


class Command
{
    private $token;
    private $password;
    private $responder;

    public function __construct(
        string $token,
        string $password
    )
    {
        $this->token = $token;
        $this->password = $password;
        $this->responder = new NullResponder();
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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