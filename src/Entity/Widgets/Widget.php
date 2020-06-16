<?php

namespace App\Entity\Widgets;

use App\Entity\Roles\Role;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Widgets\WidgetRepository")
 */
class Widget
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     */
    private $roleID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $query;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $href;

    /**
     * @ORM\Column(type="text", length=65500)
     */
    private $chartOption;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chartType;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $chart;

    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $defaultPosition;



    private $value;

    private $chartData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleID(): ?Role
    {
        return $this->roleID;
    }

    public function setRoleID(?Role $roleID): self
    {
        $this->roleID = $roleID;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(string $href): self
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }


    public function getChartOption()
    {
        return json_decode($this->chartOption);
    }

    /**
     * @return mixed
     */
    public function getChartType()
    {
        return $this->chartType;
    }

    /**
     * @return mixed
     */
    public function getChart()
    {
        return $this->chart;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function getChartData()
    {
        return $this->chartData;
    }

    /**
     * @param mixed $chartData
     */
    public function setChartData($chartData): void
    {
        $this->chartData = $chartData;
    }

    /**
     * @return mixed
     */
    public function getDefaultPosition()
    {
        return $this->defaultPosition;
    }


}
