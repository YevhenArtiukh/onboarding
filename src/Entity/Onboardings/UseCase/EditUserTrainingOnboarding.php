<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 15:35
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Onboardings\UseCase\EditUserTrainingOnboarding\Command;
use App\Entity\OnboardingTrainings\OnboardingTrainings;
use App\Entity\Users\Users;
use Doctrine\Common\Collections\ArrayCollection;

class EditUserTrainingOnboarding
{
    private $users;
    private $onboardingTrainings;
    private $transaction;

    public function __construct(
        Users $users,
        OnboardingTrainings $onboardingTrainings,
        Transaction $transaction
    )
    {
        $this->users = $users;
        $this->onboardingTrainings = $onboardingTrainings;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $onboardingTrainings = $this->onboardingTrainings->findAllNotInOnboardingForUser(
            $command->getOnboarding(),
            $command->getUser()
        );

        $command->getUser()->editOnboardingTrainings(
            new ArrayCollection(array_merge($onboardingTrainings, $command->getOnboardingTrainings()->toArray()))
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->userTrainingEdited();
    }
}