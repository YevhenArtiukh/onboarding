<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-06
 * Time: 12:49
 */

namespace App\Entity\Questions\UseCase\EditQuestion;


class Command
{
    private $id;
    private $name;
    private $type;
    private $answers;
    private $responder;

    public function __construct(
        int $id,
        string $name,
        string $type,
        ?array $answers
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->answers = $answers;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array|null
     */
    public function getAnswers(): ?array
    {
        return $this->answers;
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