<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 13:13
 */

namespace App\Entity\Questions\UseCase\CreateQuestion;


use App\Entity\Exams\Exam;

class Command
{
    private $exam;
    private $name;
    private $type;
    private $answers;
    private $responder;

    public function __construct(
        Exam $exam,
        string $name,
        string $type,
        ?array $answers
    )
    {
        $this->exam = $exam;
        $this->name = $name;
        $this->type = $type;
        $this->answers = $answers;
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