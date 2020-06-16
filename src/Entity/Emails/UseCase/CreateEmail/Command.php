<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:12
 */

namespace App\Entity\Emails\UseCase\CreateEmail;


use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $name;
    private $category;
    private $days;
    private $function;
    private $sentTo;
    private $message;
    private $variables;
    private $responder;

    public function __construct(
        string $name,
        string $category,
        array $days,
        string $function,
        ArrayCollection $sentTo,
        string $message,
        array $variables
    )
    {
        $this->name = $name;
        $this->category = $category;
        $this->days = $days;
        $this->function = $function;
        $this->sentTo = $sentTo;
        $this->message = $message;
        $this->variables = $variables;
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
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @return ArrayCollection
     */
    public function getSentTo(): ArrayCollection
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

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
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