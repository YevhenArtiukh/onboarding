<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 17:23
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Onboardings\Onboardings;
use App\Entity\Onboardings\UseCase\DeleteOnboarding\Command;

class DeleteOnboarding
{
    private $onboardings;
    private $transaction;

    public function __construct(
        Onboardings $onboardings,
        Transaction $transaction
    )
    {
        $this->onboardings = $onboardings;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingOnboarding = $this->onboardings->findOneById($command->getId());

        if(!$existingOnboarding) {
            $command->getResponder()->onboardingNotFound();
            return;
        }

        $this->onboardings->delete($existingOnboarding);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->onboardingDeleted();
    }
}