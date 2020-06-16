<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-02
 * Time: 16:20
 */

namespace App\Entity\Reports\ReadModel;


use App\Entity\Exams\Exam\Type;

class EvaluationSurveyChart
{
    private $question;
    private $answers;
    private $questionType;

    public function __construct(
        string $question,
        array $answers,
        string $questionType
    )
    {
        $this->question = $question;
        $this->answers = $answers;
        $this->questionType = $questionType;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @return string
     */
    public function getQuestionType(): string
    {
        return $this->questionType;
    }

    public function getAnswerValue(): string
    {
        switch ($this->questionType) {
            case Type::ANSWER_TYPE_RATING:
                $temp = [
                    1 => 'Bardzo źle',
                    2 => 'Źle',
                    3 => 'Przeciętnie',
                    4 => 'Dobrze',
                    5 => 'Bardzo dobrze'
                ];
                return $temp[$this->getAnswers()['choices']];
                break;
            case Type::ANSWER_TYPE_YES_NO:
                $temp = [
                    0 => 'Nie',
                    1 => 'Tak'
                ];
                return $temp[$this->getAnswers()['yesno']];
                break;
        }
    }
}