<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 16:33
 */

namespace App\Adapter\Questions\ReadModel;

use App\Entity\Exams\Exam;
use App\Entity\Questions\ReadModel\Question;
use App\Entity\Questions\ReadModel\QuestionQuery as QuestionQueryInterface;
use Doctrine\DBAL\Connection;

class QuestionQuery implements QuestionQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    /**
     * @param Exam $exam
     * @return mixed
     */
    public function findAllForExam(Exam $exam)
    {
        return $this->connection->project(
            'SELECT
                    q.id AS id,
                    q.name AS name,
                    q.type AS type
                    FROM question AS q
                    WHERE q.exam_id = :exam
                    ORDER BY q.sort ASC',
            [
                'exam' => $exam->getId()
            ],
            function (array $result) {
                return new Question(
                    (int) $result['id'],
                    (string) $result['name'],
                    (string) $result['type']
                );
            }
        );
    }
}