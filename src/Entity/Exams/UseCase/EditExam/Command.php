<?php


namespace App\Entity\Exams\UseCase\EditExam;


use App\Entity\Exams\Exam;

class Command
{
    private $exam;
    private $name;
    private $status;
    private $duration;
    private $responder;


    public function __construct(
        Exam $exam,
        string $name,
        string $status,
        int $duration
    )
    {
        $this->exam = $exam;
        $this->name = $name;
        $this->status = $status;
        $this->duration = $duration;
        $this->responder = new NullResponder();
    }

    /**
     * @return Exam
     */
    public function getExam(): Exam
    {
        return $this->exam;
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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return Responder
     */
    public function getResponder(): Responder
    {
        return $this->responder;
    }

    /**
     * @param Responder $responder
     */
    public function setResponder(Responder $responder): void
    {
        $this->responder = $responder;
    }


}