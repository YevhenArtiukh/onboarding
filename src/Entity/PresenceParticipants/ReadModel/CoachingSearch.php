<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-04
 * Time: 14:20
 */

namespace App\Entity\PresenceParticipants\ReadModel;


class CoachingSearch
{
    private $id;
    private $name;
    private $coaches;
    private $day;

    public function __construct(
        int $id,
        string $name,
        string $coaches,
        \DateTime $day
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->coaches = $coaches;
        $this->day = $day;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCoaches(): string
    {
        return $this->coaches;
    }

    /**
     * @return \DateTime
     */
    public function getDay(): \DateTime
    {
        return $this->day;
    }
}