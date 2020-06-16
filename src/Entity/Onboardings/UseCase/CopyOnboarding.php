<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-20
 * Time: 15:12
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Divisions\Division;
use App\Entity\OnboardingDivisions\OnboardingDivision;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\Onboardings;
use App\Entity\Onboardings\UseCase\CopyOnboarding\Command;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\OnboardingTrainings;

class CopyOnboarding
{
    private $onboardings;
    private $onboardingTrainings;
    private $transaction;

    public function __construct(
        Onboardings $onboardings,
        OnboardingTrainings $onboardingTrainings,
        Transaction $transaction
    )
    {
        $this->onboardings = $onboardings;
        $this->onboardingTrainings = $onboardingTrainings;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        if (!$command->getLastOnboarding()) {
            $command->getResponder()->lastOnboardingNotFound();
            return;
        }

        /**
         * @var OnboardingDivision $onboardingDivision
         */
        foreach ($command->getOnboarding()->getOnboardingDivisions() as $onboardingDivision) {
            /**
             * @var OnboardingDivision $lastOnboardingDivision
             */
            foreach ($command->getLastOnboarding()->getOnboardingDivisions() as $lastOnboardingDivision) {
                if ($onboardingDivision->getDivision() === $command->getDivision() &&
                    $lastOnboardingDivision->getDivision() === $command->getDivision() &&
                    count($onboardingDivision->getDays()) !== count($lastOnboardingDivision->getDays())) {
                    $command->getResponder()->differentNumbersOfDays();
                    return;
                }
            }
        }

        $onboardingTrainings = $this->createCopyOnboardingTrainings(
            $command->getOnboarding(),
            $command->getLastOnboarding(),
            $command->getDivision()
        );

        if(is_null($onboardingTrainings)) {
            $this->transaction->rollback();
            $command->getResponder()->conflictTrainings();
            return;
        }

        switch ($command->getOnboarding()->getStatus()) {
            case Onboarding\Status::STATUS_GENERAL:
                foreach ($this->onboardingTrainings->findGeneralInOnboarding($command->getOnboarding()) as $onboardingTraining) {
                    $this->onboardingTrainings->delete($onboardingTraining);
                }
                break;
            case Onboarding\Status::STATUS_DIVISION:
                foreach ($this->onboardingTrainings->findDivisionInOnboarding($command->getOnboarding(), $command->getDivision()) as $onboardingTraining) {
                    $this->onboardingTrainings->delete($onboardingTraining);
                }
                break;
        }

        foreach ($onboardingTrainings as $onboardingTraining) {
            $this->onboardingTrainings->add($onboardingTraining);
            $command->getOnboarding()->addOnboardingTraining($onboardingTraining);
        }


        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }

    private function createCopyOnboardingTrainings(Onboarding $onboarding, Onboarding $lastOnboarding, Division $division)
    {
        if ($onboarding->isDivision())
            $dayDiff = $this->generateNewDay($onboarding, $lastOnboarding, $division);

        /**
         * @var OnboardingTraining $onboardingTraining
         */
        foreach ($lastOnboarding->getOnboardingTrainings() as $onboardingTraining) {
            if ($onboarding->isGeneral() && $onboardingTraining->getTraining()->isGeneral()) {
                $newOnboardingTraining = new OnboardingTraining(
                    $onboarding,
                    $onboardingTraining->getTraining(),
                    $onboardingTraining->getDivision(),
                    $onboardingTraining->getType(),
                    $onboardingTraining->getCoaches(),
                    $onboardingTraining->getDay(),
                    $onboardingTraining->getTime()
                );

                $result[] = $newOnboardingTraining;
            } elseif ($onboarding->isDivision() && $onboardingTraining->getTraining()->isDivision() && $onboardingTraining->getDivision() === $division) {
                if($onboardingTraining->getTime()) {
                    $checkConflict = $this->onboardingTrainings->checkConflictTrainings(
                        $onboardingTraining->getDay()+$dayDiff,
                        $onboardingTraining->getTime(),
                        $onboarding,
                        $onboardingTraining->getTraining()->getTime(),
                        null,
                        $division
                    );
                    if($checkConflict)
                        return null;
                }

                $newOnboardingTraining = new OnboardingTraining(
                    $onboarding,
                    $onboardingTraining->getTraining(),
                    $onboardingTraining->getDivision(),
                    $onboardingTraining->getType(),
                    $onboardingTraining->getCoaches(),
                    ($onboardingTraining->getTraining()->getIsAdditional()?$onboardingTraining->getDay():($onboardingTraining->getDay() + $dayDiff)),
                    $onboardingTraining->getTime()
                );

                $result[] = $newOnboardingTraining;
            }
        }
        return $result ?? [];
    }

    private function generateNewDay(Onboarding $onboarding, Onboarding $lastOnboarding, Division $division)
    {
        /**
         * @var OnboardingDivision $onboardingDivision
         */
        foreach ($lastOnboarding->getOnboardingDivisions() as $onboardingDivision) {
            if($onboardingDivision->getDivision() === $division) {
                $firstDayLastOnboardingDivision = $onboardingDivision->getDays();
                $firstDayLastOnboardingDivision  = reset($firstDayLastOnboardingDivision);
                $firstDayLastOnboardingDivision  = new \DateTime($firstDayLastOnboardingDivision['day']);

                $lastDayLastOnboarding = $lastOnboarding->getDays();
                $lastDayLastOnboarding = end($lastDayLastOnboarding);
                $lastDayLastOnboarding = new \DateTime($lastDayLastOnboarding['day']);

                $dayDiffLastOnboarding = date_diff($firstDayLastOnboardingDivision, $lastDayLastOnboarding)->format('%d');

                $checkLastOnboarding = $dayDiffLastOnboarding + count($lastOnboarding->getDays());
            }
        }

        /**
         * @var OnboardingDivision $onboardingDivision
         */
        foreach ($onboarding->getOnboardingDivisions() as $onboardingDivision) {
            if($onboardingDivision->getDivision() === $division) {
                $firstDayOnboardingDivision = $onboardingDivision->getDays();
                $firstDayOnboardingDivision = reset($firstDayOnboardingDivision);
                $firstDayOnboardingDivision = new \DateTime($firstDayOnboardingDivision['day']);

                $lastDayOnboarding = $onboarding->getDays();
                $lastDayOnboarding = end($lastDayOnboarding);
                $lastDayOnboarding = new \DateTime($lastDayOnboarding['day']);

                $dayDiffOnboarding = date_diff($firstDayOnboardingDivision, $lastDayOnboarding)->format('%d');

                $checkOnboarding = $dayDiffOnboarding + count($onboarding->getDays());
            }
        }

        return ($checkOnboarding-$checkLastOnboarding);
    }
}