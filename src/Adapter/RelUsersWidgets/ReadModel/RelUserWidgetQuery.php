<?php


namespace App\Adapter\RelUsersWidgets\ReadModel;

use App\Entity\RelUsersWidgets\ReadModel\EndangeredDatesUser;
use App\Entity\RelUsersWidgets\ReadModel\RelUserWidgetQuery as RelUserWidgetsQueryInterface;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;

class RelUserWidgetQuery implements RelUserWidgetsQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    public function endangeredDatesByDivision(User $user)
    {
        return $this->connection->project(
            'SELECT
                    u.name as name,
                    u.surname as surname,
                    t.name as trainingName,
                    dep.name as department,
                    di.name as division,
                    o.days AS onboardingDays,
                    (DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,\';\',3),\':\',-1),2,10), \'%d.%m.%Y\'), INTERVAL oT.day DAY), INTERVAL -1 DAY)) as day
                    
                    FROM user u
                    LEFT JOIN department dep ON u.department_id = dep.id
                    LEFT JOIN division di ON dep.division_id = di.id
                    LEFT JOIN user_onboarding_training uOT ON u.id = uOT.user_id
                    LEFT JOIN onboarding_training oT ON uOT.onboarding_training_id = oT.id
                    LEFT JOIN onboarding o ON oT.onboarding_id = o.id
                    LEFT JOIN training t ON oT.training_id = t.id
                    WHERE dep.division_id = :divisionID
                    AND u.block = :userStatus
                    AND DATE_ADD(DATE_FORMAT(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,\';\',3),\':\',-1),2,10), \'%d.%m.%Y\'), \'%Y-%m-%d\'), INTERVAL oT.day -1 DAY) < CURRENT_DATE()
                    AND  
                    
                    ((SELECT u_r.score
                    FROM user_result AS u_r
                    WHERE u_r.user_id = u.id
                    AND u_r.onboarding_training_id = oT.id
                    ORDER BY u_r.date DESC
                    LIMIT 1) != 100 
                    
                    OR 
                    
                    (SELECT u_r.score
                    FROM user_result AS u_r
                    WHERE u_r.user_id = u.id
                    AND u_r.onboarding_training_id = oT.id
                    ORDER BY u_r.date DESC
                    LIMIT 1) IS NULL)
                    ORDER BY u.id ASC
                    ',
            [
                'divisionID' => $user->getDepartment()->getDivision()->getId(),
                'userStatus' => false
            ],
            function (array $result) {
                return new EndangeredDatesUser(
                    $result['name'],
                    $result['surname'],
                    $result['trainingName'],
                    $result['division'],
                    $result['department'],
                    $result['onboardingDays']?unserialize($result['onboardingDays']):null,
                    $result['day']
                );
            }
        );
    }

    public function endangeredDatesByCoach(User $user)
    {
        return $this->connection->project(
            'SELECT
                    u.name as name,
                    u.surname as surname,
                    t.name as trainingName,
                    dep.name as department,
                    di.name as division,
                    o.days AS onboardingDays,
                    (DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,\';\',3),\':\',-1),2,10), \'%d.%m.%Y\'), INTERVAL oT.day DAY), INTERVAL -1 DAY)) as day
                
                    FROM user u
                    LEFT JOIN user_onboarding_training uOT ON u.id = uOT.user_id
                    LEFT JOIN onboarding_training oT ON uOT.onboarding_training_id = oT.id
                    LEFT JOIN onboarding_training_coach oTC ON oT.id = oTC.onboarding_training_id
                    LEFT JOIN training t ON oT.training_id = t.id
                    LEFT JOIN department dep ON u.department_id = dep.id
                    LEFT JOIN division di ON dep.division_id = di.id
                    LEFT JOIN onboarding o ON oT.onboarding_id = o.id
                    WHERE oTC.user_id = :coachID
                    AND u.block = :userStatus
                    AND DATE_ADD(DATE_FORMAT(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,\';\',3),\':\',-1),2,10), \'%d.%m.%Y\'), \'%Y-%m-%d\'), INTERVAL oT.day -1 DAY) < CURRENT_DATE()
                    AND  
                    
                    ((SELECT u_r.score
                    FROM user_result AS u_r
                    WHERE u_r.user_id = u.id
                    AND u_r.onboarding_training_id = oT.id
                    ORDER BY u_r.date DESC
                    LIMIT 1) != 100 
                    
                    OR 
                    
                    (SELECT u_r.score
                    FROM user_result AS u_r
                    WHERE u_r.user_id = u.id
                    AND u_r.onboarding_training_id = oT.id
                    ORDER BY u_r.date DESC
                    LIMIT 1) IS NULL)
                    ORDER BY u.id ASC
                    ',
            [
                'coachID' => $user->getId(),
                'userStatus' => false
            ],
            function (array $result) {
                return new EndangeredDatesUser(
                    $result['name'],
                    $result['surname'],
                    $result['trainingName'],
                    $result['division'],
                    $result['department'],
                    $result['onboardingDays']?unserialize($result['onboardingDays']):null,
                    $result['day']
                );
            }
        );
    }
}