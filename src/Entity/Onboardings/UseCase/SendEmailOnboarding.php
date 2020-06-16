<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 13:42
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Emails\Emails;
use App\Entity\Onboardings\UseCase\SendEmailOnboarding\Command;
use App\Entity\Onboardings\UseCase\SendEmailOnboarding\GenerateEmailCoach;
use App\Entity\Onboardings\UseCase\SendEmailOnboarding\GenerateEmailEmployeeManager;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;

class SendEmailOnboarding
{
    private $emails;
    private $generateEmailCoach;
    private $generateEmailEmployeeManager;
    private $transaction;

    public function __construct(
        Emails $emails,
        GenerateEmailCoach $generateEmailCoach,
        GenerateEmailEmployeeManager $generateEmailEmployeeManager,
        Transaction $transaction
    )
    {
        $this->emails = $emails;
        $this->generateEmailCoach = $generateEmailCoach;
        $this->generateEmailEmployeeManager = $generateEmailEmployeeManager;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $email = $this->emails->findOneByFunction('onboarding-coach');

        if ($email) {
            /**
             * @var OnboardingTraining $onboardingTraining
             */
            foreach ($command->getOnboarding()->getOnboardingTrainings()->toArray() as $onboardingTraining) {

                /**
                 * @var User $coach
                 */
                foreach ($onboardingTraining->getCoaches()->toArray() as $coach) {
                    $this->generateEmailCoach->notify(
                        $email,
                        $coach,
                        $command->getOnboarding(),
                        $onboardingTraining
                    );
                }
            }
        }

        $email = $this->emails->findOneByFunction('onboarding-employee-manager');

        if ($email) {

            /**
             * @var OnboardingTraining $onboardingTraining
             */
            foreach ($command->getOnboarding()->getOnboardingTrainings() as $onboardingTraining) {
                if(($onboardingTraining->getDay() === 1 && isset($timeStart) && $onboardingTraining->getTime() < $timeStart) || ($onboardingTraining->getDay() === 1 && !isset($timeStart)))
                    $timeStart = $onboardingTraining->getTime();
            }

            /**
             * @var User $user
             */
            foreach ($command->getOnboarding()->getUsers()->toArray() as $user) {
                $this->generateEmailEmployeeManager->notify(
                    $email,
                    $user,
                    $command->getOnboarding(),
                    $timeStart??null
                );
            }
        }

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->emailSent();
    }
}