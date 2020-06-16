<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 17:16
 */

namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\RelUsersWidgets\RelUsersWidgets;
use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\Users\UseCase\FirstLoginUser\Command;
use App\Entity\Users\Users;
use App\Entity\Widgets\Widget;
use App\Entity\Widgets\Widgets;

class FirstLoginUser
{
    private $users;
    private $widgets;
    private $relUserWidgets;
    private $transaction;

    public function __construct(
        Users $users,
        Widgets $widgets,
        RelUsersWidgets $relUsersWidgets,
        Transaction $transaction
    )
    {
        $this->users = $users;
        $this->widgets = $widgets;
        $this->relUserWidgets = $relUsersWidgets;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingUser = $this->users->findOneById(
            $command->getId()
        );

        $widgetsByCurrentRole = $this->widgets->findAllByRole($command->getRole());

        if(!$existingUser)
            return;

        $existingUser->firstLogin(
            $command->getPassword(),
            $command->getRole()
        );

        /** @var Widget $widget */
        foreach ($widgetsByCurrentRole as $widget)
        {
            $relUserWidget = new RelUserWidget(
                $existingUser,
                $widget,
                $widget->getDefaultPosition()
            );

            $this->relUserWidgets->add($relUserWidget);
        }

        if($command->getPhoto())
            $existingUser->setPhoto($command->getPhoto()->move());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}