<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 11:00
 */

namespace App\Adapter\Users\ReadModel;

use App\Entity\Trainings\Training\TypeOfTraining;
use App\Entity\Users\ReadModel\User as UserClass;
use App\Entity\Users\ReadModel\UserQuery as UserQueryInterface;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class UserQuery implements UserQueryInterface
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
    public function findAll(User $user)
    {
        $condition = $this->getWhereQuery($user);
        if (is_null($condition))
            return [];

        return $this->connection->project(
            'SELECT
                    u.id AS id,
                    u.name AS name,
                    u.surname AS surname,
                    division.name AS division,
                    department.name AS department,
                    manager.name AS managerName,
                    business_partner.name AS partnerName,
                    manager.surname AS managerSurname,
                    business_partner.surname AS partnerSurname,
                    u.form_of_employment AS formOfEmployment,
                    u.active AS active,
                    u.block AS block,
                    O.days AS onboardingDays,
                    (
                      SELECT
                      COUNT(onboarding_training.id)
                      FROM user_onboarding_training
                      LEFT JOIN onboarding_training ON user_onboarding_training.onboarding_training_id = onboarding_training.id
                      LEFT JOIN training ON onboarding_training.training_id = training.id
                      WHERE user_onboarding_training.user_id = u.id
                      AND training.is_additional = TRUE
                      AND training.type_of_training != :pause
                    ) as countIsAdditional,
                    (
                      SELECT
                      COUNT(onboarding_training.id)
                      FROM user_onboarding_training
                      LEFT JOIN onboarding_training ON user_onboarding_training.onboarding_training_id = onboarding_training.id
                      LEFT JOIN training ON onboarding_training.training_id = training.id
                      WHERE user_onboarding_training.user_id = u.id
                      AND training.is_additional = TRUE
                      AND training.type_of_training != :pause
                      AND (
                        SELECT u_r.score
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                        ORDER BY u_r.date DESC
                        LIMIT 1
                      ) = 100
                    ) as countIsAdditionalSuccess,
                    (
                      SELECT
                      COUNT(onboarding_training.id)
                      FROM user_onboarding_training
                      LEFT JOIN onboarding_training ON user_onboarding_training.onboarding_training_id = onboarding_training.id
                      LEFT JOIN training ON onboarding_training.training_id = training.id
                      WHERE user_onboarding_training.user_id = u.id
                      AND training.is_additional = FALSE
                      AND training.type_of_training != :pause
                    ) as countNotAdditional,
                    (
                      SELECT
                      COUNT(onboarding_training.id)
                      FROM user_onboarding_training
                      LEFT JOIN onboarding_training ON user_onboarding_training.onboarding_training_id = onboarding_training.id
                      LEFT JOIN training ON onboarding_training.training_id = training.id
                      WHERE user_onboarding_training.user_id = u.id
                      AND training.is_additional = FALSE
                      AND training.type_of_training != :pause
                      AND (
                        SELECT u_r.score
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                        ORDER BY u_r.date DESC
                        LIMIT 1
                      ) = 100
                    ) as countNotAdditionalSuccess
                    FROM user u
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN division ON department.division_id = division.id
                    LEFT JOIN onboarding O ON u.onboarding_id = O.id 
                    LEFT JOIN user manager ON department.manager_id = manager.id
                    LEFT JOIN user business_partner ON department.business_partner_id = business_partner.id'
            . $condition,
            [
                'pause' => TypeOfTraining::TYPE_OF_TRAINING_PAUSE
            ],
            function (array $result) {
                return new UserClass(
                    (int)$result['id'],
                    (string)$result['name'],
                    (string)$result['surname'],
                    (string)$result['division'],
                    (string)$result['department'],
                    $result['managerName'],
                    $result['managerSurname'],
                    $result['partnerName'],
                    $result['partnerSurname'],
                    (string)$result['formOfEmployment'],
                    $result['onboardingDays'] ? unserialize($result['onboardingDays']) : null,
                    ($result['countIsAdditional'] > 0) ? number_format($result['countIsAdditionalSuccess'] * 100 / $result['countIsAdditional']) : null,
                    ($result['countNotAdditional'] > 0) ? number_format($result['countNotAdditionalSuccess'] * 100 / $result['countNotAdditional']) : null,
                    (bool)$result['active'],
                    (bool)$result['block']
                );
            }
        );
    }

    private function getWhereQuery(User $user)
    {
        switch ($user->getCurrentRole()->getName()) {
            case 'Manager':
                $condition = " WHERE manager.id = " . $user->getId();
                break;
            case 'P&O BP':
                $condition = " WHERE division.id = " . $user->getDepartment()->getDivision()->getId();
                break;
            case 'P&O BP cross-dywizyjny':
                $condition = "";
                break;
        }

        return $condition ?? null;
    }

    /**
     * @param string $token
     * @return User|null
     */
    public function passwordResetChange(string $token)
    {
        $users = $this->connection->project(
            'SELECT
                    u.id AS id,
                    u.name AS name,
                    u.surname AS surname
                    FROM user AS u
                    WHERE u.token = :token
                    AND u.token_life >= NOW()',
            [
                'token' => $token
            ],
            function (array $result) {
                return $result;
            }
        );

        if (!$users)
            return null;

        return reset($users);
    }
}