<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-04
 * Time: 14:21
 */

namespace App\Adapter\PresenceParticipants\ReadModel;


use App\Entity\OnboardingTrainings\OnboardingTraining\Type;
use App\Entity\PresenceParticipants\ReadModel\CoachingSearch;
use Doctrine\DBAL\Connection;

class PresenceParticipantQuery
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    public function coachingSearch(int $training, int $coach, ?string $date)
    {
        $condition = '';

        if($date)
            $condition = " AND DATE_FORMAT(DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y'), INTERVAL onboarding_training.day DAY), INTERVAL -1 DAY), '%d.%m.%Y') = :date";

        return $this->connection->project(
            "SELECT
                    onboarding_training.id AS onboardingTrainingId,
                    training.name AS name,
                    GROUP_CONCAT(CONCAT(coach.name, ' ',coach.surname) SEPARATOR ', ') as coaches,
                    DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y'), INTERVAL onboarding_training.day DAY), INTERVAL -1 DAY) as trainingDay
                    FROM onboarding_training
                    LEFT JOIN training ON onboarding_training.training_id = training.id
                    LEFT JOIN onboarding_training_coach ON onboarding_training.id = onboarding_training_coach.onboarding_training_id
                    LEFT JOIN user AS coach ON onboarding_training_coach.user_id = coach.id
                    LEFT JOIN onboarding ON onboarding_training.onboarding_id = onboarding.id
                    WHERE training.id = :training
                    AND coach.id = :coach
                    AND onboarding_training.type = :typePresence
                    AND DATE_ADD(DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y'), INTERVAL onboarding_training.day DAY), INTERVAL -1 DAY), INTERVAL 6 MONTH) > CURDATE()".
                    $condition.
                    " GROUP BY onboarding_training.id",
            [
                'training' => $training,
                'coach' => $coach,
                'typePresence' => Type::TYPE_PRESENCE,
                'date' => $date
            ],
            function (array $result) {
                return new CoachingSearch(
                    (int)$result['onboardingTrainingId'],
                    (string)$result['name'],
                    (string)$result['coaches'],
                    new \DateTime($result['trainingDay'])
                );
            }
        );
    }
}