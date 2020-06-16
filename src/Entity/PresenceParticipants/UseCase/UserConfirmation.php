<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 13:08
 */

namespace App\Entity\PresenceParticipants\UseCase;


use App\Core\Transaction;
use App\Entity\PresenceParticipants\PresenceParticipant;
use App\Entity\PresenceParticipants\PresenceParticipants;
use App\Entity\PresenceParticipants\UseCase\UserConfirmation\Command;
use App\Entity\UserResults\UserResult;
use App\Entity\UserResults\UserResults;

class UserConfirmation
{
    private $presenceParticipants;
    private $userResults;
    private $transaction;

    public function __construct(
        PresenceParticipants $presenceParticipants,
        UserResults $userResults,
        Transaction $transaction
    )
    {
        $this->presenceParticipants = $presenceParticipants;
        $this->userResults = $userResults;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $presenceParticipant = $this->presenceParticipants->findOneByOnboardingTrainingAndUser(
            $command->getOnboardingTraining(),
            $command->getUser()
        );

        if ($presenceParticipant) {
            $presenceParticipant->userConfirmation(
                $command->getUser()
            );
        } else {
            $presenceParticipant = new PresenceParticipant(
                $command->getOnboardingTraining()
            );
            $presenceParticipant->userConfirmation($command->getUser());

            $this->presenceParticipants->add($presenceParticipant);
        }

        $userResult = $this->userResults->findOneByOnboardingTrainingAndUser(
            $command->getOnboardingTraining(),
            $command->getUser()
        );

        if($presenceParticipant->getUserConfirmation() && $presenceParticipant->getCoachConfirmation() && !$userResult) {
            $userResult = new UserResult(
                $command->getUser(),
                $command->getOnboardingTraining(),
                100
            );
            $this->userResults->add($userResult);
        } elseif ($userResult && (!$presenceParticipant->getUserConfirmation() || !$presenceParticipant->getCoachConfirmation())) {
            $this->userResults->delete($userResult);
        }


        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->confirmed();
    }
}