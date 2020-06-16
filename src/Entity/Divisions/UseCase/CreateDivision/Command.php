<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 16:44
 */

namespace App\Entity\Divisions\UseCase\CreateDivision;


class Command
{
    private $name;
    private $messageEmail;
    private $responder;

    public function __construct(
        string $name,
        ?string $messageEmail
    )
    {
        $this->name = $name;
        $this->messageEmail = $messageEmail;
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
     * @return null|string
     */
    public function getMessageEmail(): ?string
    {
        return $this->messageEmail;
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