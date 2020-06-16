<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:13
 */

namespace App\Entity\Exams\UseCase\CreateExam;


use App\Entity\Trainings\Training;

class Command
{
    private $name;
    private $type;
    private $duration;
    private $status;
    private $training;
    private $responder;

    public function __construct(
        string $name,
        string $type,
        int $duration,
        bool $status,
        Training $training
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->duration = $duration;
        $this->status = $status;
        $this->training = $training;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }
    /**
     * @return Training
     */
    public function getTraining(): Training
    {
        return $this->training;
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