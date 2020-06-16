<?php


namespace App\Adapter\UserAnswers\ReadModel;

use App\Entity\UserAnswers\ReadModel\UserAnswers;
use App\Entity\UserAnswers\ReadModel\UserAnswersQuery as UserAnswersQueryInterface;
use App\Entity\UserResults\UserResult;
use Doctrine\DBAL\Connection;

class UserAnswersQuery implements UserAnswersQueryInterface
{
    private $connection;


    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function getAllByUserResult(UserResult $userResult)
    {
        return $this->connection->project(
            'SELECT
                    uA.id AS id,
                    uA.question AS question,
                    uA.answer AS answer,
                    uA.correct AS correct
                    FROM user_answer AS uA
                    WHERE uA.user_id = :userID
                    AND uA.user_result_id = :userResultID',
            [
                'userID' => $userResult->getUser()->getId(),
                'userResultID' => $userResult->getId()
            ],
            function (array $result) {
                return new UserAnswers(
                    (int) $result['id'],
                    (string) $result['question'],
                    (string) $result['answer'],
                    (bool) $result['correct']
                );
            }
        );
    }
}