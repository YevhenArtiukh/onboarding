<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:41
 */

namespace App\Entity\OnboardingTrainings\UseCase;


use App\Core\Transaction;
use App\Entity\OnboardingTrainings\OnboardingTrainings;
use App\Entity\OnboardingTrainings\UseCase\DeleteOnboardingTraining\Command;

class DeleteOnboardingTraining
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

        $this->onboardingTrainings->delete($existingOnboardingTraining);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
        $command->getResponder()->onboardingTrainingDeleted();
    }
}