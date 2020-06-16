<?php

namespace App\Entity\AnnualSchedules;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnualSchedules\AnnualScheduleRepository")
 */
class AnnualSchedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="array")
     */
    private $days = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    public function __construct(
        \DateTime $dateStart,
        \DateTime $dateEnd,
        array $days
    )
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->days = $days;
        $this->year = $dateStart->format('Y');
    }

    public function edit(
        \DateTime $dateStart,
        \DateTime $dateEnd,
        array $days
    )
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->days = $days;
        $this->year = $dateStart->format('Y');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(array $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }
}
