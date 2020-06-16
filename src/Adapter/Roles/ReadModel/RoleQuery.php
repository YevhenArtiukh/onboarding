<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:41
 */

namespace App\Adapter\Roles\ReadModel;

use App\Entity\Roles\ReadModel\Role;
use App\Entity\Roles\ReadModel\RoleQuery as RoleQueryInterface;
use Doctrine\DBAL\Connection;

class RoleQuery implements RoleQueryInterface
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
                    r.id AS id,
                    r.name AS name
                    FROM role AS r',
            [],
            function (array $result) {
                return new Role(
                    (int) $result['id'],
                    (string) $result['name']
                );
            }
        );
    }
}