<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 17:23
 */

namespace App\Entity\Onboardings\UseCase\DeleteOnboarding;


class Command
{
    private $id;
    private $responder;

    public function __construct(
        int $id
    )
    {
        $this->id = $id;
        $this->responder = new NullResponder();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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