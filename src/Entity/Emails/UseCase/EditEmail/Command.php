<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 13:27
 */

namespace App\Entity\Emails\UseCase\EditEmail;


class Command
{
    private $id;
    private $name;
    private $days;
    private $sentTo;
    private $message;
    private $responder;

    public function __construct(
        int $id,
        string $name,
        array $days,
        $sentTo,
        string $message
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->days = $days;
        $this->sentTo = $sentTo;
        $this->message = $message;
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
     * @return array
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * @return mixed
     */
    public function getSentTo()
    {
        return $this->sentTo;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
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