<?php


namespace App\Entity\RelUsersWidgets\UseCase\RemoveWidget;


use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\Users\Users;

class Command
{
    private $userWidget;


    public function __construct(
        RelUserWidget $userWidget
    )
    {
       $this->userWidget = $userWidget;
    }

    /**
     * @return RelUserWidget
     */
    public function getUserWidget(): RelUserWidget
    {
        return $this->userWidget;
    }


}