<?php


namespace App\Adapter\Users\ReadModel;

use App\Entity\Users\ReadModel\UserMigration;
use App\Entity\Users\ReadModel\UserMigrationQuery as UserMigrationQueryInterface;
use Doctrine\DBAL\Connection;

class UserMigrationQuery implements UserMigrationQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }


    public function findByParams(array $params)
    {
        return $this->connection->project(
            'SELECT
                    u.id AS id,
                    u.name AS name,
                    u.surname AS surname,
                    u.login AS login,
                    division.name AS divisionName,
                    department.name AS departmentName
                    FROM user u
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN division ON department.division_id = division.id'
                    . $this->getFormDataToSQL($params),
            [],
            function (array $result) {
                return new UserMigration(
                    (int)$result['id'],
                    (string)$result['name'],
                    (string)$result['surname'],
                    (string)$result['login'],
                    (string)$result['divisionName'],
                    (string)$result['departmentName']
                );
            }
        );
    }

    private function getFormDataToSQL(array $params)
    {
        $text = " WHERE u.surname LIKE '%" . $params['surname'] . "%'";
        if ($params['name']) {
            $text .= " AND u.name LIKE '%" . $params['name'] . "%'";
        }
        $text .= " AND division.id =" . $params['division']->getId();
        return $text;
    }
}