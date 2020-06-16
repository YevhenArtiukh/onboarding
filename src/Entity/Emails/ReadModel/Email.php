<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 12:20
 */

namespace App\Entity\Emails\ReadModel;


use App\Entity\Emails\ReadModel\Email\Category;

class Email
{
    private $id;
    private $name;
    private $category;
    private $days;
    private $sentTo;
    private $message;
    private $variables;

    public function __construct(
        int $id,
        string $name,
        Category $category,
        array $days,
        array $sentTo,
        string $message,
        array $variables
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->days = $days;
        $this->sentTo = $sentTo;
        $this->message = $message;
        $this->variables = $variables;
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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * @return array
     */
    public function getSentTo(): array
    {
        return $this->sentTo;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }
}