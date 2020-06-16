<?php


namespace App\Entity\Users\UseCase\ChangePassword;


use App\Entity\Users\User;

class Command
{
    private $user;
    private $password;
    private $responder;


    public function __construct(
        User $user,
        string $password
    )
    {
        $this->user = $user;
        $this->password = $password;
        $this->responder = new NullResponder();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return Responder
     */
    public function getResponder(): Responder
    {
        return $this->responder;
    }

    /**
     * @param Responder $responder
     */
    public function setResponder(Responder $responder): void
    {
        $this->responder = $responder;
    }




}