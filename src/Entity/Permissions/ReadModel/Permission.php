<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:37
 */

namespace App\Entity\Permissions\ReadModel;


class Permission
{
    private $id;
    private $name;
    private $function;

    public function __construct(
        int $id,
        string $name,
        string $function
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->function = $function;
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
    public function getFunction(): string
    {
        return $this->function;
    }
}