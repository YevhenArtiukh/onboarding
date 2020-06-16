<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 12:17
 */

namespace App\Adapter\OnboardingTrainings\ReadModel;

use App\Entity\OnboardingTrainings\ReadModel\CoachOnboardingTraining;
use App\Entity\OnboardingTrainings\ReadModel\CoachOnboardingTrainingQuery as CoachOnboardingTrainingQueryInterface;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;

class CoachOnboardingTrainingQuery implements CoachOnboardingTrainingQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function findAll(User $user)
    {
         return $this->connection->project(
             "SELECT
                    onboarding_training.id AS id,
                    onboarding_training.time AS startTime,
                    onboarding_training.day AS trainingDay,
                    training.name AS name,
                    training.time AS duration,
                    training.is_additional AS isAdditional,
                    training.kind_of_training AS kindOfTraining,
                    STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y') as dateStart,
                    COUNT(employee.id) AS count,
                    onboarding.days AS onboardingDays,
                    onboarding_division.days AS onboardingDivisionDays
                    FROM onboarding_training
                    LEFT JOIN onboarding_training_coach ON onboarding_training.id = onboarding_training_coach.onboarding_training_id
                    LEFT JOIN user AS u ON onboarding_training_coach.user_id = u.id
                    LEFT JOIN training ON onboarding_training.training_id = training.id
                    LEFT JOIN user_onboarding_training ON onboarding_training.id = user_onboarding_training.onboarding_training_id
                    LEFT JOIN user AS employee ON user_onboarding_training.user_id = employee.id
                    LEFT JOIN onboarding ON onboarding_training.onboarding_id = onboarding.id
                    LEFT JOIN onboarding_division ON (onboarding.id = onboarding_division.onboarding_id AND onboarding_training.division_id = onboarding_division.division_id)
                    WHERE u.id = :user
                    GROUP BY onboarding_training.id",
             [
                 'user' => $user->getId()
             ],
             function (array $result) {
                 return new CoachOnboardingTraining(
                     (int)$result['id'],
                     (string)$result['startTime'],
                     (int)$result['trainingDay'],
                     (string)$result['name'],
                     (int)$result['duration'],
                     (bool)$result['isAdditional'],
                     (string)$result['kindOfTraining'],
                     (string)$result['dateStart'],
                     (int)$result['count'],
                     unserialize($result['onboardingDays']),
                     $result['onboardingDivisionDays']?unserialize($result['onboardingDivisionDays']):null
                 );
             }
         );
    }
}