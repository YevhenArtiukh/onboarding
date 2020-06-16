<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 13:08
 */

namespace App\Entity\OnboardingTrainings\UseCase;


use App\Core\Transaction;
use App\Entity\OnboardingTrainings\OnboardingTrainings;
use App\Entity\OnboardingTrainings\UseCase\EditOnboardingTrainingAdditional\Command;

class EditOnboardingTrainingAdditional
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

        $existingOnboardingTraining->edit(
            $command->getTraining(),
            $command->getCoaches(),
            $command->getType(),
            $command->getDay()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            throw $e;
        }

        $command->getResponder()->onboardingTrainingEdited();
    }
}