<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 14:44
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Onboardings\UseCase\AddUserOnboarding\Command;
use App\Entity\OnboardingTrainings\OnboardingTrainings;
use App\Entity\Users\User;
use App\Entity\Users\Users;
use Doctrine\Common\Collections\ArrayCollection;
use LogicException;

class AddUserOnboarding
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

        if($this->users->findOneByEmail($command->getEmail())) {
            $command->getResponder()->emailExists();
            return;
        }

        $onboardingTrainingsGeneral = $this->onboardingTrainings->findGeneralInOnboarding($command->getOnboarding());
        $onboardingTrainingsDivision = $this->onboardingTrainings->findDivisionInOnboarding($command->getOnboarding(), $command->getDivision());

        $user = new User(
            $command->getName(),
            $command->getSurname(),
            $command->getEmail(),
            $command->getDepartment(),
            $command->getIdentifier(),
            $command->getPosition(),
            $command->getFormOfEmployment(),
            $command->getTypeOfWorker(),
            $command->getRoles(),
            $this->generateLogin($command->getName(),$command->getSurname()),
            $this->generatePassword($command->getName(),$command->getSurname()),
            $command->getOnboarding(),
            new ArrayCollection(array_merge($onboardingTrainingsGeneral,$onboardingTrainingsDivision))
        );

        $this->users->add($user);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->userCreated();
    }

    private function generateLogin(string $name, string $surname)
    {
        $string = strtolower(substr($name,0,3)).strtolower(substr($surname,0,3));

        $number = '01';

        if($lastLogin = $this->users->findLastForGenerateLogin($string)) {
            $number = (int)substr($lastLogin->getLogin(),-2);
            $number++;
            $number = ($number<9)?('0'.$number):$number;
        }

        return $string.$number;
    }

    private function generatePassword(string $name, string $surname)
    {
        $string = password_hash(strtolower(substr($name,0,3)).strtolower(substr($surname,0,3)), PASSWORD_BCRYPT);

        return $string;
    }
}