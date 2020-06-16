<?php

namespace App\Entity\RelUsersWidgets;

use App\Entity\Users\User;
use App\Entity\Users\Users;
use App\Entity\Widgets\Widget;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RelUsersWidgets\RelUserWidgetRepository")
 */
class RelUserWidget
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $relUserWidgetID;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", onDelete="CASCADE")
     */
    private $userID;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Widgets\Widget")
     * @ORM\JoinColumn(name="widget_id", referencedColumnName="id")
     */
    private $widgetID;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;




    public function __construct(
        User $userID,
        Widget $widgetID,
        int  $position
    )
    {
        $this->userID = $userID;
        $this->widgetID = $widgetID;
        $this->position = $position;

    }

    /**
     * @return mixed
     */
    public function getRelUserWidgetID()
    {
        return $this->relUserWidgetID;
    }

    /**
     * @return User
     */
    public function getUserID(): User
    {
        return $this->userID;
    }

    /**
     * @return Widget
     */
    public function getWidgetID(): Widget
    {
        return $this->widgetID;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
}
