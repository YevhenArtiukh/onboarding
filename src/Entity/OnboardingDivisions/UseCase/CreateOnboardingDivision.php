<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:42
 */

namespace App\Entity\OnboardingDivisions\UseCase;


use App\Core\Transaction;
use App\Entity\OnboardingDivisions\OnboardingDivision;
use App\Entity\OnboardingDivisions\OnboardingDivisions;
use App\Entity\OnboardingDivisions\UseCase\CreateOnboardingDivision\Command;

class CreateOnboardingDivision
{
    private $onboardingDivisions;
    private $transaction;

    public function __construct(
        OnboardingDivisions $onboardingDivisions,
        Transaction $transaction
    )
    {
        $this->onboardingDivisions = $onboardingDivisions;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingOnboardingDivision = $this->onboardingDivisions->findOneByOnboardingAndDivision($command->getOnboarding(), $command->getDivision());

        if($existingOnboardingDivision) {
            $command->getResponder()->onboardingDivisionExists();
            return;
        }

        $onboardingDivision = new OnboardingDivision(
            $command->getOnboarding(),
            $command->getDivision(),
            $command->getDays()
        );

        $this->onboardingDivisions->add($onboardingDivision);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}