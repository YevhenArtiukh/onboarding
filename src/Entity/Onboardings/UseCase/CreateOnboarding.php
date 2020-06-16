<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:30
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\Onboardings;
use App\Entity\Onboardings\UseCase\CreateOnboarding\Command;

class CreateOnboarding
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

        $onboarding = new Onboarding(
            $command->getDays()
        );

        $this->onboardings->add($onboarding);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->onboardingCreated();

        return $onboarding->getId();
    }
}