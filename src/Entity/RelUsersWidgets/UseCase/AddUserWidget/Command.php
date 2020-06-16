<?php


namespace App\Entity\RelUsersWidgets\UseCase\AddUserWidget;


use App\Entity\Users\User;
use App\Entity\Widgets\Widget;

class Command
{
    private $user;
    private $widgetID;
    private $position;


    public function __construct(
        User $user,
        Widget $widgetID,
        int $position
    )
    {
        $this->user = $user;
        $this->widgetID = $widgetID;
        $this->position = $position;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
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