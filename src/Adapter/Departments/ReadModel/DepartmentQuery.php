<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-25
 * Time: 12:36
 */

namespace App\Adapter\Departments\ReadModel;

use App\Entity\Departments\ReadModel\Department;
use App\Entity\Departments\ReadModel\DepartmentQuery as DepartmentQueryInterface;
use Doctrine\DBAL\Connection;

class DepartmentQuery implements DepartmentQueryInterface
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
        $this->connection->project(
            'SELECT 
                    d.id AS id,
                    d.name AS name
                    FROM department AS d',
            [],
            function (array $result) {
                return new Department(
//                    (int) $result['id']
                );
            }
        );
    }
}