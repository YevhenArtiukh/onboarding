<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:29
 */

namespace App\Adapter\Exams\ReadModel;

use App\Entity\Exams\ReadModel\Exam;
use App\Entity\Exams\ReadModel\ExamQuery as ExamQueryInterface;
use App\Entity\Trainings\Training;
use Doctrine\DBAL\Connection;

class ExamQuery implements ExamQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->connection->project(
            'SELECT
                    e.id AS id,
                    e.name AS name,
                    e.type AS type,
                    e.duration AS duration,
                    t.name AS training,
                    e.is_active AS isActive
                    FROM exam AS e
                    LEFT JOIN training AS t ON e.training_id = t.id',
            [],
            function (array $result) {
                return new Exam(
                    (int) $result['id'],
                    (string) $result['name'],
                    (string) $result['type'],
                    (int) $result['duration'],
                    (bool) $result['isActive'],
                    (string) $result['training']
                );
            }
        );
    }

    public function getAllByTraining(Training $training)
    {
        return $this->connection->project(
            'SELECT
                    e.id AS id,
                    e.name AS name,
                    e.type AS type,
                    e.duration AS duration,
                    t.name AS training,
                    e.is_active AS isActive,
                    e.date_of_modification AS dateOfModification,
                    COUNT(q.id) AS countQuestions
                    FROM exam AS e
                    LEFT JOIN training AS t ON e.training_id = t.id
                    LEFT JOIN question AS q on e.id = q.exam_id
                    WHERE t.id = :trainingID
                    GROUP BY e.id',
            [
                'trainingID' => $training->getId()
            ],
            function (array $result) {
                return new Exam(
                    (int) $result['id'],
                    (string) $result['name'],
                    (string) $result['type'],
                    (int) $result['duration'],
                    (bool) $result['isActive'],
                    (int) $result['countQuestions'],
                    (string) $result['dateOfModification'],
                    (string) $result['training']
                );
            }
        );
    }
}