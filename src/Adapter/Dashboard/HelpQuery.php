<?php


namespace App\Adapter\Dashboard;


use Doctrine\DBAL\Connection;

class HelpQuery
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    public function getLastOnboarding()
    {
        return $this->connection->
        createQueryBuilder()
            ->select('*')
            ->from('onboarding', 'o')
            ->orderBy("STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y')", 'DESC')
            ->setMaxResults(1)
            ->execute()
            ->fetchColumn();
    }

    public function getOneByEvaluationSurvey()
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('t.id')
            ->from('training', 't')
            ->andWhere('t.is_evaluation_survey = :status')
            ->setParameter('status', true)
            ->setMaxResults(1)
            ->execute()
            ->fetchColumn();
    }
}