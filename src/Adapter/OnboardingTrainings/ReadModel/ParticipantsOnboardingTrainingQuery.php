<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 14:18
 */

namespace App\Adapter\OnboardingTrainings\ReadModel;

use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\ReadModel\ParticipantsOnboardingTraining;
use App\Entity\OnboardingTrainings\ReadModel\ParticipantsOnboardingTrainingQuery as ParticipantsOnboardingTrainingQueryInterface;
use Doctrine\DBAL\Connection;

class ParticipantsOnboardingTrainingQuery implements ParticipantsOnboardingTrainingQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    /**
     * @param OnboardingTraining $onboardingTraining
     * @return mixed
     */
    public function findAll(OnboardingTraining $onboardingTraining)
    {
        return $this->connection->project(
            'SELECT
                    u.id AS id,
                    u.name AS name,
                    u.surname AS surname,
                    department.name AS department,
                    manager.name AS managerName,
                    manager.surname AS managerSurname,
                    (
                      SELECT u_r.score
                      FROM user_result AS u_r
                      WHERE u_r.user_id = u.id
                      AND u_r.onboarding_training_id = :onboardingTraining
                      AND u_r.date = MAX(user_result.date)
                    ) as score,
                    MAX(user_result.date) AS date,
                    presence_participant.user_confirmation AS userConfirmation,
                    presence_participant.coach_confirmation AS coachConfirmation,
                    presence_participant.datetime AS datetime
                    FROM user AS u
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN user AS manager ON department.manager_id = manager.id
                    LEFT JOIN user_onboarding_training ON u.id = user_onboarding_training.user_id
                    LEFT JOIN user_result ON (u.id = user_result.user_id AND user_result.onboarding_training_id = :onboardingTraining)
                    LEFT JOIN presence_participant ON (presence_participant.onboarding_training_id = :onboardingTraining AND presence_participant.user_id = u.id)
                    WHERE user_onboarding_training.onboarding_training_id = :onboardingTraining
                    GROUP BY u.id',
            [
                'onboardingTraining' => $onboardingTraining->getId()
            ],
            function (array $result) {
                return new ParticipantsOnboardingTraining(
                    (int)$result['id'],
                    (string)$result['name'],
                    (string)$result['surname'],
                    (string)$result['department'],
                    $result['managerName'],
                    $result['managerSurname'],
                    $result['date']?(new \DateTime($result['date']))->format('d.m.Y'):null,
                    (int)$result['score'],
                    $result['userConfirmation']?true:false,
                    $result['coachConfirmation']?true:false,
                    $result['datetime']?(new \DateTime($result['datetime'])):null
                );
            }
        );
    }
}