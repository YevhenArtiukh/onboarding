<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 12:35
 */

namespace App\Entity\OnboardingTrainings\UseCase;


use App\Core\Transaction;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\OnboardingTrainings;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTrainingAdditional\Command;

class CreateOnboardingTrainingAdditional
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

        $onboardingTraining = new OnboardingTraining(
            $command->getOnboarding(),
            $command->getTraining(),
            $command->getDivision(),
            $command->getType(),
            $command->getCoaches(),
            $command->getDay()
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