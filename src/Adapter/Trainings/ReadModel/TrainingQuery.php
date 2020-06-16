<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:50
 */

namespace App\Adapter\Trainings\ReadModel;

use App\Entity\Trainings\ReadModel\Training;
use App\Entity\Trainings\ReadModel\TrainingQuery as TrainingQueryInterface;
use App\Entity\Trainings\Training\KindOfTraining;
use Doctrine\DBAL\Connection;

class TrainingQuery implements TrainingQueryInterface
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
    public function getGeneral()
    {
        return $this->connection->project(
            'SELECT
                    t.id AS id,
                    t.name AS name,
                    t.time AS trainingTime,
                    t.image AS image
                    FROM training AS t
                    WHERE t.kind_of_training = :kindOfTraining',
            ['kindOfTraining' => KindOfTraining::KIND_OF_TRAINING_GENERAL],
            function (array $result) {
                return new Training(
                    (int) $result['id'],
                    (string) $result['name'],
                    (string) $result['trainingTime'],
                    $result['image']
                );
            }
        );
    }

}