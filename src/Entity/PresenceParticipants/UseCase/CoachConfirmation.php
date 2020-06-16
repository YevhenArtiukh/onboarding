<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 15:01
 */

namespace App\Entity\PresenceParticipants\UseCase;


use App\Core\Transaction;
use App\Entity\PresenceParticipants\PresenceParticipant;
use App\Entity\PresenceParticipants\PresenceParticipants;
use App\Entity\PresenceParticipants\UseCase\CoachConfirmation\Command;
use App\Entity\UserResults\UserResult;
use App\Entity\UserResults\UserResults;
use App\Entity\Users\Users;

class CoachConfirmation
{
    private $presenceParticipants;
    private $users;
    private $userResults;
    private $transaction;

    public function __construct(
        PresenceParticipants $presenceParticipants,
        Users $users,
        UserResults $userResults,
        Transaction $transaction
    )
    {
        $this->presenceParticipants = $presenceParticipants;
        $this->users = $users;
        $this->userResults = $userResults;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        foreach ($command->getUsers() as $idUser) {
            $user = $this->users->findOneById($idUser);

            if (!$user) {
                $command->getResponder()->userNotFound();
                return;
            }

            $presenceParticipant = $this->presenceParticipants->findOneByOnboardingTrainingAndUser(
                $command->getOnboardingTraining(),
                $user
            );

            if (!$presenceParticipant) {
                $presenceParticipant = new PresenceParticipant(
                    $command->getOnboardingTraining()
                );
                $presenceParticipant
                    ->coachConfirmation($command->getCoach())
                    ->setUser($user);

                $this->presenceParticipants->add($presenceParticipant);
            } else {
                $presenceParticipant->coachConfirmation(
                    $command->getCoach()
                );
            }

            $userResult = $this->userResults->findOneByOnboardingTrainingAndUser(
                $command->getOnboardingTraining(),
                $user
            );

            if($presenceParticipant->getUserConfirmation() && $presenceParticipant->getCoachConfirmation() && !$userResult) {
                $userResult = new UserResult(
                    $user,
                    $command->getOnboardingTraining(),
                    100
                );
                $this->userResults->add($userResult);
            } elseif ($userResult && (!$presenceParticipant->getUserConfirmation() || !$presenceParticipant->getCoachConfirmation())) {
                $this->userResults->delete($userResult);
            }
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