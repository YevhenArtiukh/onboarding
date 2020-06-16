<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:38
 */

namespace App\Adapter\Permissions\ReadModel;

use App\Entity\Permissions\ReadModel\Permission;
use App\Entity\Permissions\ReadModel\PermissionQuery as PermissionQueryInterface;
use Doctrine\DBAL\Connection;

class PermissionQuery implements PermissionQueryInterface
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
                    p.id AS id,
                    p.name AS name,
                    p.function AS function
                    FROM permission AS p',
            [],
            function (array $result) {
                return new Permission(
                    (int) $result['id'],
                    (string) $result['name'],
                    (string) $result['function']
                );
            }
        );
    }
}