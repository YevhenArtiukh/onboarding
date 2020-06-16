<?php


namespace App\Adapter\UserResults\ReadModel;

use App\Entity\OnboardingTrainings\OnboardingTraining\Type;
use App\Entity\UserResults\ReadModel\UserResults;
use App\Entity\UserResults\ReadModel\UserResultsQuery as UserResultsQueryInterface;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;

class UserResultsQuery implements UserResultsQueryInterface
{

    private $connection;


    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    public function getAllByUser(User $user)
    {
        return $this->connection->project(
            'SELECT
                    uR.id AS id,
                    T.name AS name,
                    uR.date AS date,
                    uR.score AS score,
                    E.type AS currentExamType,
                    oT.type AS onboardingTrainingType
                    FROM user_result AS uR
                    LEFT JOIN onboarding_training oT ON uR.onboarding_training_id = oT.id
                    LEFT JOIN training T ON oT.training_id = T.id 
                    LEFT JOIN exam E on E.training_id = T.id 
                    WHERE uR.user_id = :userID
                    AND E.is_active = :status
                    AND oT.type = :typeOnboardingTraining
                    ',
            [
                'userID' => $user->getId(),
                'status' => true,
                'typeOnboardingTraining' =>  Type::TYPE_TEST
            ],
            function (array $result) {
                return new UserResults(
                    (int) $result['id'],
                    (string) $result['name'],
                     new \DateTime($result['date']),
                    $result['score'],
                    $result['currentExamType'],
                    $result['onboardingTrainingType']
                );
            }
        );
    }
}