<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-03
 * Time: 14:42
 */

namespace App\Entity\Reports\ReadModel;


use App\Entity\Exams\Exam\Type;

class EvaluationSurveyExport
{
    private $question;
    private $questionType;
    private $answers;
    private $userResultId;

    public function __construct(
        string $question,
        string $questionType,
        array $answers,
        int $userResultId
    )
    {
        $this->question = $question;
        $this->questionType = $questionType;
        $this->answers = $answers;
        $this->userResultId = $userResultId;
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
    public function getQuestionType(): string
    {
        return $this->questionType;
    }

    /**
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @return int
     */
    public function getUserResultId(): int
    {
        return $this->userResultId;
    }

    public function getAnswerValue(): string
    {
        $rating = [
            '',
            'Bardzo źle',
            'Źle',
            'Przeciętnie',
            'Dobrze',
            'Bardzo dobrze'
        ];

        switch ($this->getQuestionType()) {
            case Type::ANSWER_TYPE_RATING:
                $answer = $rating[$this->getAnswers()['choices']];
                break;
            case Type::ANSWER_TYPE_COMMENT:
                $answer = $this->getAnswers()['comment'];
                break;
            case Type::ANSWER_TYPE_YES_NO:
                $answer = ($this->getAnswers()['yesno'] ? 'Tak' : 'Nie');
                break;
            case Type::ANSWER_TYPE_RATING_COMMENT:
                $answer = "(Ocena) - " . $rating[$this->getAnswers()['choices']] . " | (Komentarz) - " . $this->getAnswers()['comment'];
                break;
        }

        return $answer;
    }
}