<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 17:37
 */

namespace App\Adapter\Divisions\ReadModel;

use App\Entity\Divisions\ReadModel\Division;
use App\Entity\Divisions\ReadModel\DivisionQuery as DivisionQueryInterface;
use Doctrine\DBAL\Connection;

class DivisionQuery implements DivisionQueryInterface
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
    public function findAll()
    {
        return $this->connection->project(
            'SELECT 
                    d.id AS id,
                    d.name AS name,
                    d.message_email AS messageEmail
                    FROM division AS d',
            [],
            function (array $result) {
                return new Division(
                    (int)$result['id'],
                    (string)$result['name'],
                    $result['messageEmail']
                );
            }
        );
    }
}