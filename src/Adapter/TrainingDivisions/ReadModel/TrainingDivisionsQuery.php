<?php


namespace App\Adapter\TrainingDivisions\ReadModel;

use App\Entity\Divisions\Division;
use App\Entity\TrainingDivisions\ReadModel\TrainingDivisionsQuery as TrainingDivisionsQueryInterface;
use App\Entity\Trainings\ReadModel\Training;
use App\Entity\Trainings\Training\KindOfTraining;
use Doctrine\DBAL\Connection;

class TrainingDivisionsQuery implements TrainingDivisionsQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    public function getByDivision(Division $division)
    {
        return $this->connection->project(
            'SELECT
                    t.id AS id,
                    t.name AS name,
                    t.time AS trainingTime,
                    t.image AS image
                    FROM training_division AS tD
                    LEFT JOIN training t on tD.training_id = t.id
                    WHERE tD.division_id = :divisionID
                    AND t.kind_of_training = :kindOfTraining',
            [
                'divisionID' => $division->getId(),
                'kindOfTraining' => KindOfTraining::KIND_OF_TRAINING_DIVISIONS],
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