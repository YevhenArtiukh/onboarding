<?php


namespace App\Entity\Users\ReadModel;


class UserMigration
{
    private $id;
    private $name;
    private $surname;
    private $login;
    private $divisionName;
    private $departmentName;

    public function __construct(
        int $id,
        string $name,
        string $surname,
        string $login,
        string $divisionName,
        string $departmentName
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->login = $login;
        $this->divisionName = $divisionName;
        $this->departmentName = $departmentName;
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
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getDivisionName(): string
    {
        return $this->divisionName;
    }

    /**
     * @return string
     */
    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

}