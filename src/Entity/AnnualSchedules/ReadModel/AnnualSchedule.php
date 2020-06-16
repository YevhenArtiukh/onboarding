<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 13:02
 */

namespace App\Entity\AnnualSchedules\ReadModel;


class AnnualSchedule
{
    private $id;
    private $dateStart;
    private $dateEnd;
    private $pharma;
    private $onco;
    private $sandoz;
    private $year;

    public function __construct(
        int $id,
        \DateTime $dateStart,
        \DateTime $dateEnd,
        ?string $pharma,
        ?string $onco,
        ?string $sandoz,
        int $year
    )
    {
        $this->id = $id;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->pharma = $pharma;
        $this->onco = $onco;
        $this->sandoz = $sandoz;
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @return null|string
     */
    public function getPharma(): ?string
    {
        return $this->pharma;
    }

    /**
     * @return null|string
     */
    public function getOnco(): ?string
    {
        return $this->onco;
    }

    /**
     * @return null|string
     */
    public function getSandoz(): ?string
    {
        return $this->sandoz;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    public function getMonth()
    {
        $months = [
            '',
            'Styczeń',
            'Luty',
            'Marzec',
            'Kwiecień',
            'Maj',
            'Czerwiec',
            'Lipiec',
            'Sierpień',
            'Wrzesień',
            'Październik',
            'Listopad',
            'Grudzień'
        ];

        return $months[$this->dateStart->format('n')];
    }
}