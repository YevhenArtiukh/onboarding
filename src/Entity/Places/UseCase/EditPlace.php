<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:45
 */

namespace App\Entity\Places\UseCase;


use App\Core\Transaction;
use App\Entity\Places\Places;
use App\Entity\Places\UseCase\EditPlace\Command;

class EditPlace
{
    private $places;
    private $transaction;

    public function __construct(
        Places $places,
        Transaction $transaction
    )
    {
        $this->places = $places;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingPlace = $this->places->findOneById($command->getId());

        if(!$existingPlace) {
            $command->getResponder()->placeNotFound();
            return;
        }

        $existingPlace->edit(
            $command->getName()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
        $command->getResponder()->placeEdited();
    }
}