<?php


namespace App\Entity\Questions\UseCase\DeleteQuestion;


use App\Entity\Questions\Question;

class Command
{
    private $question;
    private $responder;


    public function __construct(
        Question $question
    )
    {
        $this->question = $question;
        $this->responder = new NullResponder();
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
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