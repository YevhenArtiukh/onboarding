<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:28
 */

namespace App\Entity\Exams\ReadModel;


class Exam
{
    private $id;
    private $name;
    private $type;
    private $duration;
    private $isActive;
    private $dateOfModification;
    private $countQuestions;
    private $training;

    public function __construct(
        int $id,
        string $name,
        string $type,
        int $duration,
        bool $isActive,
        int $countQuestions,
        string $dateOfModification,
        string $training
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->duration = $duration;
        $this->isActive = $isActive;
        $this->countQuestions = $countQuestions;
        $this->dateOfModification = $dateOfModification;
        $this->training = $training;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getTraining(): string
    {
        return $this->training;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function isActiveString(): string
    {
        return ($this->isActive)?'Aktywny':'Nieaktywny';
    }

    /**
     * @return string
     */
    public function getDateOfModification(): string
    {
        return $this->dateOfModification;
    }

    /**
     * @return int
     */
    public function getCountQuestions(): int
    {
        return $this->countQuestions;
    }
}