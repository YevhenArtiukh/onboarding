<?php


namespace App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire;


final class Rating
{
    const RATING_VERY_GOOD = 5;
    const RATING_GOOD = 4;
    const RATING_MIDDLE = 3;
    const RATING_BAD = 2;
    const RATING_VERY_BAD = 1;

    private $rating;

    public function __construct($rating)
    {
        $this->rating = $rating;
    }

    public function isVeryGood()
    {
        return $this->rating === self::RATING_VERY_GOOD;
    }

    public function isGood()
    {
        return $this->rating === self::RATING_GOOD;
    }

    public function isMiddle()
    {
        return $this->rating === self::RATING_MIDDLE;
    }

    public function isBad()
    {
        return $this->rating === self::RATING_BAD;
    }

    public function isVeryBad()
    {
        return $this->rating === self::RATING_VERY_BAD;
    }


    public function __toString()
    {
        return $this->rating;
    }
}