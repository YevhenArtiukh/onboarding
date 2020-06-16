<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:31
 */

namespace App\Adapter\Places\ReadModel;

use App\Entity\Places\ReadModel\Place;
use App\Entity\Places\ReadModel\PlaceQuery as PlaceQueryInterface;
use Doctrine\DBAL\Connection;

class PlaceQuery implements PlaceQueryInterface
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
                    p.name AS name
                    FROM place AS p',
            [],
            function (array $result) {
                return new Place(
                    (int) $result['id'],
                    (string) $result['name']
                );
            }
        );
    }
}