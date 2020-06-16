<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-23
 * Time: 12:02
 */

namespace App\Adapter\Users\ReadModel;

use App\Entity\Trainings\Training\TypeOfTraining;
use App\Entity\Users\ReadModel\UserOnboardingTraining;
use App\Entity\Users\ReadModel\UserOnboardingTrainingQuery as UserOnboardingTrainingQueryInterface;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;

class UserOnboardingTrainingQuery implements UserOnboardingTrainingQueryInterface
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
    public function findAllForUser(User $user)
    {
        return $this->connection->project(
            "SELECT
                    o_t.id AS onboardingTrainingId,
                    t.name AS trainingName,
                    o.days AS firstDay,
                    o_t.day AS trainingDay,
                    GROUP_CONCAT(CONCAT(coach.name, ' ',coach.surname) SEPARATOR ', ') as coaches,
                    (
                        SELECT u_r.score
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = o_t.id
                        ORDER BY u_r.date DESC
                        LIMIT 1
                    ) as score,
                    o_t.type AS onboardingTrainingType,
                    t.is_additional AS trainingIsAdditional
                    FROM user AS u
                    LEFT JOIN user_onboarding_training AS u_o_t ON u.id = u_o_t.user_id
                    LEFT JOIN onboarding_training AS o_t ON u_o_t.onboarding_training_id = o_t.id
                    LEFT JOIN training AS t ON o_t.training_id = t.id
                    LEFT JOIN onboarding AS o ON o_t.onboarding_id = o.id
                    LEFT JOIN onboarding_training_coach AS o_t_c ON o_t.id = o_t_c.onboarding_training_id
                    LEFT JOIN user AS coach ON o_t_c.user_id = coach.id
                    WHERE u.id = :user
                    AND t.type_of_training != :pause
                    GROUP BY o_t.id
                    ORDER BY
                    STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y') ASC,
                    o_t.day ASC,
                    t.name ASC
                    ",
            [
                'user' => $user->getId(),
                'pause' => TypeOfTraining::TYPE_OF_TRAINING_PAUSE
            ],
            function (array $result) {
                return new UserOnboardingTraining(
                    (int)$result['onboardingTrainingId'],
                    (string)$result['trainingName'],
                    new \DateTime(unserialize($result['firstDay'])[0]['day']),
                    (int)$result['trainingDay'],
                    $result['coaches'],
                    (int)$result['score'],
                    (string)$result['onboardingTrainingType'],
                    (bool)$result['trainingIsAdditional']
                );
            }
        );
    }
}