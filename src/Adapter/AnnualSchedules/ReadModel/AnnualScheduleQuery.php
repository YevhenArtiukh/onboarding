<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 13:03
 */

namespace App\Adapter\AnnualSchedules\ReadModel;

use App\Entity\AnnualSchedules\ReadModel\AnnualSchedule;
use App\Entity\AnnualSchedules\ReadModel\AnnualScheduleQuery as AnnualScheduleQueryInterface;
use Doctrine\DBAL\Connection;

class AnnualScheduleQuery implements AnnualScheduleQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    /**
     * @param int $year
     * @return mixed
     */
    public function findAll(int $year)
    {
        return $this->connection->project(
            'SELECT
                    a_s.id AS id,
                    a_s.date_start AS date_start,
                    a_s.date_end AS date_end,
                    a_s.days AS days,
                    a_s.year AS year
                    FROM annual_schedule AS a_s
                    WHERE a_s.year = :year',
            [
                'year' => $year
            ],
            function (array $result) {
                return new AnnualSchedule(
                    (int)$result['id'],
                    new \DateTime($result['date_start']),
                    new \DateTime($result['date_end']),
                    $this->transformData(unserialize($result['days']), 'Pharma'),
                    $this->transformData(unserialize($result['days']), 'Oncology'),
                    $this->transformData(unserialize($result['days']), 'Sandoz'),
                    (int)$result['year']
                );
            }
        );
    }

    private function transformData(array $days, string $divisionName)
    {
        foreach ($days as $day) {
            if ($day['division']->getName() === $divisionName)
                return $day['dateStart'].' - '.$day['dateEnd'];
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getListYear()
    {
        return $this->connection->project(
            'SELECT
                    a_s.year AS year
                    FROM annual_schedule AS a_s
                    GROUP BY a_s.year DESC',
            [],
            function (array $result) {
                return (int)$result['year'];
            }
        );
    }
}