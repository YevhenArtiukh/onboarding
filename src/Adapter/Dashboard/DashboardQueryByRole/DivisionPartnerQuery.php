<?php


namespace App\Adapter\Dashboard\DashboardQueryByRole;


use App\Adapter\Dashboard\HelpQuery;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;

class DivisionPartnerQuery
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
     * kafelek z ilością osób zapisanych na najbliższy onboarding z dywizji w której pracuje P&O
     * @param User $user
     * @return false|mixed
     */
    public function countWorkersByLastOnboardingAndDivision(User $user)
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('count(u.id)')
            ->from('user', 'u')
            ->leftJoin('u', 'department', 'dep', 'u.department_id = dep.id')
            ->where('u.onboarding_id = :onboardingID')
            ->andWhere('dep.division_id = :divisionID')
            ->andWhere('u.block = :userStatus')
            ->setParameter('onboardingID', $this->helpQuery->getLastOnboarding())
            ->setParameter('divisionID', $user->getDepartment()->getDivision()->getId())
            ->setParameter('userStatus', false)
            ->execute()
            ->fetchColumn();
    }

    /**
     * kafelek z ilością osób zapisanych na najbliższy onboarding z wszystkich dywizji
     * @return false|mixed
     */
    public function countWorkersByLastOnboarding()
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('count(u.id)')
            ->from('user', 'u')
            ->where('u.onboarding_id = :onboardingID')
            ->andWhere('u.block = :userStatus')
            ->setParameter('onboardingID', $this->helpQuery->getLastOnboarding())
            ->setParameter('userStatus', false)
            ->execute()
            ->fetchColumn();
    }

    /**
     * kafelek z liczbą osób w systemie (użytkowników w systemie) z dywizji w której pracuje P&O
     * @param User $user
     * @return false|mixed
     */
    public function countWorkersByDivision(User $user)
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('count(u.id)')
            ->from('user', 'u')
            ->leftJoin('u', 'department', 'dep', 'u.department_id = dep.id')
            ->andWhere('dep.division_id = :divisionID')
            ->andWhere('u.block = :userStatus')
            ->setParameter('divisionID', $user->getDepartment()->getDivision()->getId())
            ->setParameter('userStatus', false)
            ->execute()
            ->fetchColumn();
    }

    /**
     * kafelek z liczbą osób z danej dywizji które mają zaległe szkolenia
     * @param User $user
     * @return false|mixed
     */
    public function countWorkersEndangeredDates(User $user)
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('count(DISTINCT u.id)')
            ->from('user', 'u')
            ->leftJoin('u', 'department', 'dep', 'u.department_id = dep.id')
            ->leftJoin('u', 'user_onboarding_training', 'uOT', 'u.id = uOT.user_id')
            ->leftJoin('uOT', 'onboarding_training', 'oT', 'uOT.onboarding_training_id = oT.id')
            ->leftJoin('oT', 'onboarding', 'o', 'oT.onboarding_id = o.id')
            ->andWhere('dep.division_id = :divisionID')
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
            ->setParameter('divisionID', $user->getDepartment()->getDivision()->getId())
            ->setParameter('userStatus', false)
            ->execute()
            ->fetchColumn();
    }

    /**
     * wykres kołowy (Ilość osób która wypełniła ankietę ewaluacyjną - wykres pokazuje ile osób na daną chwilę wypełniło już ankietę ewaluacyjną z ostatniego onb oraz ilość osób które jeszcze nie wypełniły - (makieta 2)
     * @param User $user
     * @return array
     */
    public function smallChartCountWorkersAEByDivision(User $user)
    {
        $countUserRecordedAE =
            $this->connection->createQueryBuilder()
                ->select('count(*)')
                ->from('user_onboarding_training', 'uOT')
                ->leftJoin('uOT', 'onboarding_training', 'oT', 'uOT.onboarding_training_id = oT.id')
                ->leftJoin('uOT', 'user', 'u', 'uOT.user_id = u.id')
                ->leftJoin('u', 'department', 'dep', 'u.department_id = dep.id')
                ->where('oT.onboarding_id = :onboardingID')
                ->andWhere('oT.training_id = :trainingID')
                ->andWhere('dep.division_id = :divisionID')
                ->setParameter('onboardingID', $this->helpQuery->getLastOnboarding())
                ->setParameter('trainingID', $this->helpQuery->getOneByEvaluationSurvey())
                ->setParameter('divisionID', $user->getDepartment()->getDivision()->getId())
                ->execute()
                ->fetchColumn();

        $countUserCompletedAE =
            $this->connection->createQueryBuilder()
                ->select('count(uR.id)')
                ->from('user_result', 'uR')
                ->leftJoin('uR', 'onboarding_training', 'oT', 'uR.onboarding_training_id = oT.id')
                ->leftJoin('uR', 'user', 'u', 'uR.user_id = u.id')
                ->leftJoin('u', 'department', 'dep', 'u.department_id = dep.id')
                ->where('oT.onboarding_id = :onboardingID')
                ->andWhere('oT.training_id = :trainingID')
                ->andWhere('dep.division_id = :divisionID')
                ->setParameter('onboardingID', $this->helpQuery->getLastOnboarding())
                ->setParameter('trainingID', $this->helpQuery->getOneByEvaluationSurvey())
                ->setParameter('divisionID', $user->getDepartment()->getDivision()->getId())
                ->execute()
                ->fetchColumn();

        $resultData = [
            'Wypełnili' => $countUserCompletedAE,
            'Nie wypełnili' => ($countUserRecordedAE - $countUserCompletedAE)
        ];

        return [
            'datasets' => [[
                'backgroundColor' => ["#1E88E5", "#ECEFF1"],
                'data' => array_values($resultData)
            ]],
            'labels' => [
                'Wypełnili',
                'Nie wypełnili'
            ]
        ];
    }
}