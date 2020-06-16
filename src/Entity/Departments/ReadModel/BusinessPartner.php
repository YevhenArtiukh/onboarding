<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-22
 * Time: 15:19
 */

namespace App\Entity\Departments\ReadModel;


class BusinessPartner
{
    private $id;
    private $name;
    private $surname;
    private $count;

    public function __construct(
        $id,
        $name,
        $surname,
        $count
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name??'Obszary bez P&O BP';
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }
}