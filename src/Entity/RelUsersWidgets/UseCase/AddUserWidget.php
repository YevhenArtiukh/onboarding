<?php


namespace App\Entity\RelUsersWidgets\UseCase;


use App\Core\Transaction;
use App\Entity\RelUsersWidgets\RelUsersWidgets;
use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\RelUsersWidgets\UseCase\AddUserWidget\Command;
use App\Entity\Widgets\Widgets;

class AddUserWidget
{
    private $relUsersWidgets;
    private $transaction;


    public function __construct(
        RelUsersWidgets $relUsersWidgets,
        Transaction $transaction
    )
    {
        $this->relUsersWidgets = $relUsersWidgets;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {


        $this->transaction->begin();

        $relUserWidget = new RelUserWidget(
            $command->getUser(),
            $command->getWidgetID(),
            $command->getPosition()
        );
        $this->relUsersWidgets->add($relUserWidget);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }

}