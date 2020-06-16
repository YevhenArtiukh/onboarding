<?php


namespace App\Entity\UserAnswers\ReadModel;


class UserAnswers
{
    private $id;
    private $question;
    private $answer;
    private $correct;


    public function __construct(
        int $id,
        string $question,
        string $answer,
        bool $correct
    )
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
        $this->correct = $correct;
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
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->correct;
    }



}