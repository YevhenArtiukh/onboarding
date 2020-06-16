<?php


namespace App\Entity\Questions\UseCase\ChangeSortQuestion;


class Command
{
    private $currentQuestionID;
    private $toChangeQuestionID;
    private $responder;

    public function __construct(
        int $currentQuestionID,
        int $toChangeQuestionID
        )
    {
        $this->currentQuestionID = $currentQuestionID;
        $this->toChangeQuestionID = $toChangeQuestionID;
        $this->responder = new NullResponder();
    }

    /**
     * @return int
     */
    public function getCurrentQuestionID(): int
    {
        return $this->currentQuestionID;
    }

    /**
     * @return int
     */
    public function getToChangeQuestionID(): int
    {
        return $this->toChangeQuestionID;
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