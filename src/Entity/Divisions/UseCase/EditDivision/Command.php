<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 16:58
 */

namespace App\Entity\Divisions\UseCase\EditDivision;


class Command
{
    private $id;
    private $name;
    private $messageEmail;
    private $responder;

    public function __construct(
        int $id,
        string $name,
        ?string $messageEmail
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->messageEmail = $messageEmail;
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