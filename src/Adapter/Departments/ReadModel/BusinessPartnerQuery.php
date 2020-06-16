<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-22
 * Time: 15:20
 */

namespace App\Adapter\Departments\ReadModel;

use App\Entity\Departments\ReadModel\BusinessPartner;
use App\Entity\Departments\ReadModel\BusinessPartnerQuery as BusinessPartnerQueryInterface;
use App\Entity\Divisions\Division;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;

class BusinessPartnerQuery implements BusinessPartnerQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    /**
     * @param Division $division
     * @return mixed
     */
    public function findAll(Division $division)
    {
        return $this->connection->project(
            'SELECT
                    u.id AS id,
                    u.name AS name,
                    u.surname AS surname,
                    COUNT(d.id) AS count
                    FROM department AS d
                    LEFT JOIN user AS u ON d.business_partner_id = u.id
                    LEFT JOIN division AS division ON d.division_id = division.id
                    WHERE division.id = :division
                    GROUP BY u.id
                    ',
            [
                'division' => $division->getId()
            ],
            function (array $result) {
                return new BusinessPartner(
                    $result['id'],
                    $result['name'],
                    $result['surname'],
                    $result['count']
                );
            }
        );
    }

    /**
     * @param User|null $user
     * @param Division $division
     * @return mixed
     */
    public function findByIdBusinessPartner(?User $user, Division $division)
    {
        $query = 'SELECT
                    d.name AS name
                    FROM department AS d
                    LEFT JOIN user AS u ON d.business_partner_id = u.id
                    LEFT JOIN division AS division ON d.division_id = division.id
                    WHERE division.id = :division      
                    ';
        $query .= ($user) ? 'AND u.id = :user ' : 'AND u.id IS NULL ';
        $query .= 'ORDER BY d.name ASC';

        return $this->connection->project(
            $query,
            [
                'user' => $user ? $user->getId() : null,
                'division' => $division->getId()
            ],
            function (array $result) {
                return $result['name'];
            }
        );
    }
}