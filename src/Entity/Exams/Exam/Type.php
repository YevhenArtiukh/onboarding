<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:09
 */

namespace App\Entity\Exams\Exam;


final class Type
{
    const TYPE_TEST = 'Test';
    const TYPE_ANKIETA = 'Ankieta';

    const ANSWER_TYPE_CHOOSE = 'odpowiedzi do wyboru';
    const ANSWER_TYPE_RATING = 'wybór 1 oceny ze skali';
    const ANSWER_TYPE_COMMENT = 'możliwość wpisania odpowiedzi/komentarza';
    const ANSWER_TYPE_YES_NO = 'wybór Tak/Nie';
    const ANSWER_TYPE_RATING_COMMENT = 'wybór 1 oceny ze skali + możliwość dodania komentarza';

    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function isTest()
    {
        return $this->type === self::TYPE_TEST;
    }

    public function isAnkieta()
    {
        return $this->type === self::TYPE_ANKIETA;
    }

    public function generateAnswersType()
    {
        switch ($this->type) {
            case self::TYPE_TEST:
                $answersType = [
                    self::ANSWER_TYPE_CHOOSE => self::ANSWER_TYPE_CHOOSE
                ];
                break;
            case self::TYPE_ANKIETA:
                $answersType = [
                    self::ANSWER_TYPE_RATING => self::ANSWER_TYPE_RATING,
                    self::ANSWER_TYPE_COMMENT => self::ANSWER_TYPE_COMMENT,
                    self::ANSWER_TYPE_YES_NO => self::ANSWER_TYPE_YES_NO,
                    self::ANSWER_TYPE_RATING_COMMENT => self::ANSWER_TYPE_RATING_COMMENT,
                ];
                break;
        }

        return $answersType;
    }

    public function __toString()
    {
        return $this->type;
    }
}