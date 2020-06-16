<?php


namespace App\Entity\Exams\UseCase\DeleteExam;


use App\Entity\Exams\Exam;

class Command
{
    private $exam;
    private $responder;


    public function __construct(
        Exam $exam)
    {
        $this->exam = $exam;
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