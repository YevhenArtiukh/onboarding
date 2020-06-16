<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:01
 */

namespace App\Entity\Permissions\UseCase\CreatePermission;


class Command
{
    private $name;
    private $function;
    private $responder;

    public function __construct(
        string $name,
        string $function
    )
    {
        $this->name = $name;
        $this->function = $function;
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
    public function getFunction(): string
    {
        return $this->function;
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