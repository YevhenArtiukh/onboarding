<?php


namespace App\Adapter\Dashboard\DashboardQueryByRole;


use App\Adapter\Dashboard\HelpQuery;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class CoachQuery
{
    private $helpQuery;
    private $connection;

    public function __construct(
        HelpQuery $helpQuery,
        Connection $connection
    )
    {
        $this->helpQuery = $helpQuery;
        $this->connection = $connection;
    }

    /**
     * Kafelek z liczbą osób zapisanych na szkolenia prowadzone przez danego trenera, które mają zaległe szkolenia (przekroczony został termin realizacji szkoleń)
     * @param User $user
     * @return false|mixed
     */
    public function countWorkersEndangeredDatesByCoach(User $user)
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('count(DISTINCT u.id)')
            ->from('user', 'u')
            ->leftJoin('u', 'user_onboarding_training', 'uOT', 'u.id = uOT.user_id')
            ->leftJoin('uOT', 'onboarding_training', 'oT', 'uOT.onboarding_training_id = oT.id')
            ->leftJoin('oT', 'onboarding', 'o', 'oT.onboarding_id = o.id')
            ->leftJoin('oT', 'onboarding_training_coach', 'oTC', 'oT.id = oTC.onboarding_training_id')
            ->andWhere('u.block = :userStatus')
            ->andWhere("DATE_ADD(DATE_FORMAT(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y'), '%Y-%m-%d'), INTERVAL oT.day -1 DAY) < CURRENT_DATE()")
            ->andWhere("
            
                    (SELECT u_r.score
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
                    LIMIT 1) IS NULL")
            ->andWhere('oTC.user_id = :coachID')
            ->setParameter('coachID', $user->getId())
            ->setParameter('userStatus', false)
            ->execute()
            ->fetchColumn();
    }

    public function nearTrainings(User $user)
    {
        return $this->connection->createQueryBuilder()
            ->select("DATE_FORMAT(DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y'), INTERVAL ot.day DAY), INTERVAL -1 DAY), '%Y-%m-%d') as date, ot.time as time")
            ->from('onboarding_training', 'ot')
            ->leftJoin('ot', 'onboarding', 'o', 'ot.onboarding_id = o.id')
            ->innerJoin('ot', 'onboarding_training_coach', 'otc', 'ot.id = otc.onboarding_training_id')
            ->leftJoin('otc', 'user', 'c', 'otc.user_id = c.id')
            ->where("DATE_FORMAT(DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y'), INTERVAL ot.day DAY), INTERVAL -1 DAY), '%Y-%m-%d') > NOW()")
            ->andWhere('c.id = :user')
            ->setMaxResults(3)
            ->orderBy("DATE_FORMAT(DATE_ADD(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y'), INTERVAL ot.day DAY), INTERVAL -1 DAY), '%Y-%m-%d')")
            ->setParameter('user', $user->getId())
            ->execute()
            ->fetchAll();
    }

    /**
     * Wykres Ilość osób w onboardingu w podziale na dywizje - czyli ile osób z każdej z dywizji jest w danej chwili zapisanych na najbliższy onboarding (makieta 4)
     * @return array
     */
    public function smallChartCountWorkersByLastOnboardingByDivision()
    {
        $usersByLastOnboarding =
            $this->connection->createQueryBuilder()
                ->select('u.id, di.name')
                ->from('user', 'u')
                ->leftJoin('u', 'department', 'dep', 'u.department_id = dep.id')
                ->leftJoin('dep', 'division', 'di', 'dep.division_id = di.id')
                ->where('u.onboarding_id = :onboardingID')
                ->setParameter('onboardingID', $this->helpQuery->getLastOnboarding())
                ->execute()
                ->fetchAll();

        $resultData = [
            'Pharma' => 0,
            'Oncology' => 0,
            'Sandoz' => 0,
        ];

        foreach ($usersByLastOnboarding as $userByLastOnboarding) {
            $resultData[$userByLastOnboarding['name']]++;
        }

        return [
            'datasets' => [[
                'backgroundColor' => ["#FC4B6C", "#00ACC1", "#1E88E5"],
                'data' => array_values($resultData)
            ]],
            'labels' => [
                'Pharma',
                'Onco',
                'Sandoz',
            ]
        ];
    }

}