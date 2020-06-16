<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:22
 */

namespace App\Entity\Permissions\UseCase\EditPermission;


class Command
{
    private $id;
    private $name;
    private $function;
    private $responder;

    public function __construct(
        int $id,
        string $name,
        string $function
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->function = $function;
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