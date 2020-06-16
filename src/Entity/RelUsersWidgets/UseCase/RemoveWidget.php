<?php


namespace App\Entity\RelUsersWidgets\UseCase;


use App\Core\Transaction;
use App\Entity\RelUsersWidgets\RelUsersWidgets;
use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\RelUsersWidgets\UseCase\RemoveWidget\Command;
use Symfony\Component\HttpFoundation\JsonResponse;

class RemoveWidget
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

        if(!$this->relUsersWidgets)
            return new JsonResponse(false, 400);

        $this->transaction->begin();

        $this->relUsersWidgets->remove($command->getUserWidget());


        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        return new JsonResponse( ['widgetID' =>$command->getUserWidget()->getWidgetID()->getId() ]);


    }

}