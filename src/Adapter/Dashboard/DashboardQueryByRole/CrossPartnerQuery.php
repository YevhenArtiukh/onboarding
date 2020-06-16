<?php


namespace App\Adapter\Dashboard\DashboardQueryByRole;


use App\Adapter\Dashboard\HelpQuery;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class CrossPartnerQuery
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

//-

    /**
     * Kafelek z ilością osób zapisanych na najbliższy onboarding z wszystkich dywizji]
     * @return mixed
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
     * Kafelek z liczbą osób w systemie (użytkowników w systemie)
     * @return mixed
     */
    public function countWorkers()
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('count(u.id)')
            ->from('user', 'u')
            ->andWhere('u.block = :userStatus')
            ->setParameter('userStatus', false)
            ->execute()
            ->fetchColumn();
    }

    /**
     * wykres kołowy (Ilość osób która wypełniła ankietę ewaluacyjną - wykres pokazuje ile osób na daną chwilę wypełniło już ankietę ewaluacyjną z ostatniego onb per dywizja oraz ilość osób które jeszcze nie wypełniły - (makieta 3)
     *  AE - ankieta ewaluacyjna
     * @return array
     */
    public function smallChartCountWorkersAE()
    {
        $countUserOnboardingTrainingLastOnboardingAndAE =
            $this->connection->createQueryBuilder()
                ->select('count(*)')
                ->from('user_onboarding_training', 'uOT')
                ->leftJoin('uOT', 'onboarding_training', 'oT', 'uOT.onboarding_training_id = oT.id')
                ->where('oT.onboarding_id = :onboardingID')
                ->andWhere('oT.training_id = :trainingID')
                ->setParameter('onboardingID', $this->helpQuery->getLastOnboarding())
                ->setParameter('trainingID', $this->helpQuery->getOneByEvaluationSurvey())
                ->execute()
                ->fetchColumn();

        $userResultsByLastOnboardingAndAE =
            $this->connection->createQueryBuilder()
                ->select('di.name')
                ->from('user_result', 'uR')
                ->leftJoin('uR', 'onboarding_training', 'oT', 'uR.onboarding_training_id = oT.id')
                ->leftJoin('uR', 'user', 'u', 'uR.user_id = u.id')
                ->leftJoin('u', 'department', 'dep', 'u.department_id = dep.id')
                ->leftJoin('dep', 'division', 'di', 'dep.division_id = di.id')
                ->where('oT.onboarding_id = :onboardingID')
                ->andWhere('oT.training_id = :trainingID')
                ->setParameter('onboardingID', $this->helpQuery->getLastOnboarding())
                ->setParameter('trainingID', $this->helpQuery->getOneByEvaluationSurvey())
                ->execute()
                ->fetchAll(FetchMode::COLUMN);
        $countUserResultsByLastOnboardingAndAE = count($userResultsByLastOnboardingAndAE);

        $resultData = [
            'Sandoz' => 0,
            'Oncology' => 0,
            'Pharma' => 0,
            'Nie wypełnili' => ($countUserOnboardingTrainingLastOnboardingAndAE - $countUserResultsByLastOnboardingAndAE)
        ];

        foreach ($userResultsByLastOnboardingAndAE as $userResult) {
            $resultData[$userResult]++;
        }

        return [
            'datasets' => [[
                'backgroundColor' => ["#FC4B6C", "#00ACC1", "#1E88E5", "#ECEFF1"],
                'data' => array_values($resultData)
            ]],
            'labels' => [
                'Sandoz',
                'Onco',
                'Pharma',
                'Nie wypełnili'
            ]
        ];
    }


}