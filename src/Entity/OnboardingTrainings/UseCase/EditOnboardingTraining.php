<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:21
 */

namespace App\Entity\OnboardingTrainings\UseCase;


use App\Core\Transaction;
use App\Entity\OnboardingTrainings\OnboardingTrainings;
use App\Entity\OnboardingTrainings\UseCase\EditOnboardingTraining\Command;

class EditOnboardingTraining
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

        $existingOnboardingTraining = $this->onboardingTrainings->findOneById($command->getId());

        if(!$existingOnboardingTraining) {
            $command->getResponder()->onboardingTrainingNotFound();
            return;
        }

        $checkConflict = $this->onboardingTrainings->checkConflictTrainings(
            $command->getDay(),
            $command->getTime(),
            $command->getOnboarding(),
            $command->getTraining()->getTime(),
            $command->getId(),
            $command->getDivision()
        );

        if($checkConflict) {
            $command->getResponder()->conflictTrainings();
            return;
        }

        $existingOnboardingTraining->edit(
            $command->getTraining(),
            $command->getCoaches(),
            $command->getType(),
            $command->getDay(),
            $command->getTime()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->onboardingTrainingEdited();
    }
}