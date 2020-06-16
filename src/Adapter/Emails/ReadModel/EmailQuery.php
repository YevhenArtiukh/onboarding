<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 12:18
 */

namespace App\Adapter\Emails\ReadModel;

use App\Entity\Emails\ReadModel\Email;
use App\Entity\Emails\ReadModel\Email\Category;
use App\Entity\Emails\ReadModel\EmailQuery as EmailQueryInterface;
use Doctrine\DBAL\Connection;

class EmailQuery implements EmailQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    public function getList()
    {
        return $this->connection->project(
            'SELECT
                    e.id AS id,
                    e.name AS name,
                    e.category AS category,
                    e.days AS days,
                    e.message AS message,
                    e.variables AS variables
                    FROM email AS e',
            [],
            function (array $result) {
                return new Email(
                    (int) $result['id'],
                    (string) $result['name'],
                    new Category($result['category']),
                    (array) $result['days'],
                    array(),
                    (string) $result['message'],
                    unserialize($result['variables'])
                );
            }
        );
    }
}