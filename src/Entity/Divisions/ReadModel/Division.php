<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 17:34
 */

namespace App\Entity\Divisions\ReadModel;


class Division
{
    private $id;
    private $name;
    private $messageEmail;

    public function __construct(
        int $id,
        string $name,
        ?string $messageEmail
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->messageEmail = $messageEmail;
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
     * @return null|string
     */
    public function getMessageEmail(): ?string
    {
        return $this->messageEmail;
    }
}