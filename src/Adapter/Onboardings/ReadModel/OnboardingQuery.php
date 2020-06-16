<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 14:22
 */

namespace App\Adapter\Onboardings\ReadModel;

use App\Entity\Onboardings\ReadModel\Onboarding\Status;
use App\Entity\Onboardings\ReadModel\Onboarding;
use App\Entity\Onboardings\ReadModel\OnboardingQuery as OnboardingQueryInterface;
use Doctrine\DBAL\Connection;

class OnboardingQuery implements OnboardingQueryInterface
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
                    o.id AS id,
                    o.days AS days,
                    o.status AS status,
                    (
                    SELECT o_d.days
                    FROM onboarding_division AS o_d
                    LEFT JOIN division AS d ON o_d.division_id = d.id
                    WHERE o.id = o_d.onboarding_id
                    AND d.name = :pharma
                    ) as pharma,
                    (
                    SELECT o_d.days
                    FROM onboarding_division AS o_d
                    LEFT JOIN division AS d ON o_d.division_id = d.id
                    WHERE o.id = o_d.onboarding_id
                    AND d.name = :onco
                    ) as onco,
                    (
                    SELECT o_d.days
                    FROM onboarding_division AS o_d
                    LEFT JOIN division AS d ON o_d.division_id = d.id
                    WHERE o.id = o_d.onboarding_id
                    AND d.name = :sandoz
                    ) as sandoz,
                    COUNT(DISTINCT u.id) AS countUser
                    FROM onboarding AS o
                    LEFT JOIN user AS u ON o.id = u.onboarding_id
                    GROUP BY o.id',
            [
                'pharma' => 'Pharma',
                'onco' => 'Oncology',
                'sandoz' => 'Sandoz'
            ],
            function (array $result) {
                return new Onboarding(
                    (int) $result['id'],
                    unserialize($result['days']),
                    new Status($result['status']),
                    $result['pharma']?unserialize($result['pharma']):null,
                    $result['onco']?unserialize($result['onco']):null,
                    $result['sandoz']?unserialize($result['sandoz']):null,
                    (int)$result['countUser']
                );
            }
        );
    }
}