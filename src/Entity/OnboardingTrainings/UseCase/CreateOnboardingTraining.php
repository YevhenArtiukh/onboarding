<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 12:16
 */

namespace App\Entity\OnboardingTrainings\UseCase;


use App\Core\Transaction;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\OnboardingTrainings;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTraining\Command;
use LogicException;

class CreateOnboardingTraining
{
    private $onboardingTrainings;
    private $transaction;

    public function __construct(
        OnboardingTrainings $onboardingTrainings,
        Transaction $transaction
    )
    {
        $this->onboardingTrainings = $onboardingTrainings;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $checkConflict = $this->onboardingTrainings->checkConflictTrainings(
            $command->getDay(),
            $command->getTime(),
            $command->getOnboarding(),
            $command->getTraining()->getTime(),
            null,
            $command->getDivision()
        );

        if($checkConflict) {
            $command->getResponder()->conflictTrainings();
            return;
        }

        $onboardingTraining = new OnboardingTraining(
            $command->getOnboarding(),
            $command->getTraining(),
            $command->getDivision(),
            $command->getType(),
            $command->getCoaches(),
            $command->getDay(),
            $command->getTime()
        );

        $this->onboardingTrainings->add($onboardingTraining);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->onboardingTrainingCreated();
    }
}