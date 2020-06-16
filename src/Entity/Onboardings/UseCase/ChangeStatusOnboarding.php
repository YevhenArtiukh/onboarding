<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:06
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Emails\Emails;
use App\Entity\OnboardingDivisions\OnboardingDivisions;
use App\Entity\Onboardings\Onboarding\Status;
use App\Entity\Onboardings\UseCase\ChangeStatusOnboarding\Command;
use App\Entity\Onboardings\UseCase\ChangeStatusOnboarding\GenerateEmailDivision;
use App\Entity\Onboardings\UseCase\ChangeStatusOnboarding\GenerateEmailGeneral;
use App\Entity\Roles\Role;
use App\Entity\Users\User;

class ChangeStatusOnboarding
{
    private $onboardingDivisions;
    private $emails;
    private $generateEmailGeneral;
    private $generateEmailDivision;
    private $transaction;

    public function __construct(
        OnboardingDivisions $onboardingDivisions,
        Emails $emails,
        GenerateEmailGeneral $generateEmailGeneral,
        GenerateEmailDivision $generateEmailDivision,
        Transaction $transaction
    )
    {
        $this->onboardingDivisions = $onboardingDivisions;
        $this->emails = $emails;
        $this->generateEmailGeneral = $generateEmailGeneral;
        $this->generateEmailDivision = $generateEmailDivision;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        if (Status::STATUS_DIVISION === $command->getOnboarding()->getStatus()) {
            $existingOnboardingDivision = $this->onboardingDivisions->findOneByOnboardingAndDivision($command->getOnboarding(), $command->getDivision());

            if ($existingOnboardingDivision)
                $existingOnboardingDivision->setConfirmation(true);

            $email = $this->emails->findOneByFunction('onboarding-division');

            if ($email) {
                /**
                 * @var Role $role
                 */
                foreach ($email->getSentTo()->toArray() as $role) {
                    /**
                     * @var User $user
                     */
                    foreach ($role->getUsers()->toArray() as $user) {
                        $this->generateEmailDivision->notify(
                            $email,
                            $user,
                            $command->getOnboarding(),
                            $command->getDivision()
                        );
                    }
                }
            }
        } else {
            $command->getOnboarding()->setStatus(
                Status::STATUS_DIVISION
            );

            $email = $this->emails->findOneByFunction('onboarding-general');

            if ($email) {
                /**
                 * @var Role $role
                 */
                foreach ($email->getSentTo()->toArray() as $role) {
                    /**
                     * @var User $user
                     */
                    foreach ($role->getUsers()->toArray() as $user) {
                        $this->generateEmailGeneral->notify(
                            $email,
                            $user,
                            $command->getOnboarding()
                        );
                    }
                }
            }
        }

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}