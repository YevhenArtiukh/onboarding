<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:20
 */

namespace App\Entity\Places\UseCase;


use App\Core\Transaction;
use App\Entity\Places\Place;
use App\Entity\Places\Places;
use App\Entity\Places\UseCase\CreatePlace\Command;

class CreatePlace
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

        $place = new Place(
            $command->getName()
        );

        $this->places->add($place);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->placeCreated();
    }
}