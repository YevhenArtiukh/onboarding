<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:48
 */

namespace App\Entity\Trainings\ReadModel;


class Training
{
    private $id;
    private $name;
    private $time;
    private $image;

    public function __construct(
        int $id,
        string $name,
        int $time,
        ?string $image
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->time = $time;
        $this->image = $image;
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
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
}