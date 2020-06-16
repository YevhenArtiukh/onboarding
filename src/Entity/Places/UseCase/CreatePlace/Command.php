<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:20
 */

namespace App\Entity\Places\UseCase\CreatePlace;


class Command
{
    private $name;
    private $responder;

    public function __construct(
        string $name
    )
    {
        $this->name = $name;
        $this->responder = new NullResponder();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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