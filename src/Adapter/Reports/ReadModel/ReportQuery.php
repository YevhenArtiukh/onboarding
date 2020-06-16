<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-28
 * Time: 14:44
 */

namespace App\Adapter\Reports\ReadModel;


use App\Entity\Divisions\Division;
use App\Entity\Reports\ReadModel\EvaluationSurveyChart;
use App\Entity\Reports\ReadModel\EvaluationSurveyExport;
use App\Entity\Reports\ReadModel\ExportDataDateBetween;
use App\Entity\Reports\ReadModel\ExportDataUserSearch;
use App\Entity\Reports\ReadModel\NumberOfParticipants;
use App\Entity\Trainings\Training\TypeOfTraining;
use App\Entity\Users\User;
use Doctrine\DBAL\Connection;

class ReportQuery
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    public function exportDataDateBetween(User $user, string $dateStart, string $dateEnd)
    {
        switch ($user->getCurrentRole()->getName()) {
            case 'Manager':
                $condition = " AND manager.id = :manager";
                break;
            case 'P&O BP':
                $condition = " AND division.id = :division";
                break;
        }

        return $this->connection->project(
            "SELECT
                    u.id AS userId,
                    u.name AS userName,
                    u.surname AS userSurname,
                    IF(
                      u.block,
                      'zablokowany',
                      IF(
                        u.active,
                        'aktywny',
                        'nieaktywny'
                      )
                    ) as userStatus,
                    manager.name AS managerName,
                    manager.surname AS managerSurname,
                    business_partner.name AS businessPartnerName,
                    business_partner.surname AS businessPartnerSurname,
                    division.name AS division,
                    department.name AS department,
                    parent_department.name AS parentDepartment,
                    IF(
                        onboarding.id,
                        STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y'),
                        STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(user_onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y')
                    ) as onboardingDay,
                    IF(
                        onboarding.id,
                        onboarding.id,
                        user_onboarding.id
                    ) as onboardingId,
                    training.name AS training,
                    (
                        SELECT u_r.score
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                        ORDER BY u_r.date DESC
                        LIMIT 1
                    ) as resultScore,
                    (
                        SELECT u_r.date
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                        ORDER BY u_r.date DESC
                        LIMIT 1
                    ) as resultDate,
                    (
                        SELECT COUNT(u_r.id)
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                    ) as resultTry
                    FROM user AS u
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN user AS manager ON department.manager_id = manager.id
                    LEFT JOIN user AS business_partner ON department.business_partner_id = business_partner.id
                    LEFT JOIN division ON department.division_id = division.id
                    LEFT JOIN department AS parent_department ON department.parent_id = parent_department.id
                    LEFT JOIN user_onboarding_training ON u.id = user_onboarding_training.user_id
                    LEFT JOIN onboarding_training ON user_onboarding_training.onboarding_training_id = onboarding_training.id
                    LEFT JOIN training ON onboarding_training.training_id = training.id
                    LEFT JOIN onboarding ON onboarding_training.onboarding_id = onboarding.id
                    LEFT JOIN onboarding AS user_onboarding ON u.onboarding_id = user_onboarding.id
                    WHERE IF(
                        onboarding.id,
                        STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y') BETWEEN STR_TO_DATE(:dateStart, '%d.%m.%Y') AND STR_TO_DATE(:dateEnd, '%d.%m.%Y'),
                        STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(user_onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y') BETWEEN STR_TO_DATE(:dateStart, '%d.%m.%Y') AND STR_TO_DATE(:dateEnd, '%d.%m.%Y')
                    )
                    AND training.type_of_training != :trainingPause" . (isset($condition) ? $condition : ''),
            [
                'manager' => $user->getId(),
                'division' => $user->getDepartment()->getDivision()->getId(),
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'trainingPause' => TypeOfTraining::TYPE_OF_TRAINING_PAUSE
            ],
            function (array $result) {
                return new ExportDataDateBetween(
                    (int)$result['userId'],
                    (string)$result['userName'],
                    (string)$result['userSurname'],
                    (string)$result['userStatus'],
                    $result['managerName'],
                    $result['managerSurname'],
                    $result['businessPartnerName'],
                    $result['businessPartnerSurname'],
                    (string)$result['division'],
                    (string)$result['department'],
                    (string)$result['parentDepartment'],
                    new \DateTime($result['onboardingDay']),
                    (int)$result['onboardingId'],
                    $result['training'],
                    $result['resultScore'],
                    $result['resultDate'] ? new \DateTime($result['resultDate']) : null,
                    $result['resultTry']
                );
            }
        );
    }

    public function exportDataUserSearch(User $user, ?string $name, string $surname, ?int $department, ?int $userId = null)
    {
        $condition = '';
        if ($name) $condition .= ' AND LOWER(u.name) LIKE :name';
        if ($surname) $condition .= ' AND LOWER(u.surname) LIKE :surname';
        if ($department) $condition .= ' AND department.id = :department';

        if ($userId) $condition = ' AND u.id = :userId';

        switch ($user->getCurrentRole()->getName()) {
            case 'Manager':
                $condition .= " AND manager.id = :manager";
                break;
            case 'P&O BP':
                $condition .= " AND division.id = :division";
                break;
        }


        return $this->connection->project(
            "SELECT
                    u.id AS userId,
                    u.name AS userName,
                    u.surname AS userSurname,
                    u.login AS userLogin,
                    manager.name AS managerName,
                    manager.surname AS managerSurname,
                    business_partner.name AS businessPartnerName,
                    business_partner.surname AS businessPartnerSurname,
                    department.name AS department,
                    IF(
                        onboarding.id,
                        STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y'),
                        null 
                    ) as onboardingDay,
                    training.name AS training,
                    (
                        SELECT u_r.score
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                        ORDER BY u_r.date DESC
                        LIMIT 1
                    ) as resultScore,
                    (
                        SELECT u_r.date
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                        ORDER BY u_r.date DESC
                        LIMIT 1
                    ) as resultDate,
                    (
                        SELECT COUNT(u_r.id)
                        FROM user_result AS u_r
                        WHERE u_r.user_id = u.id
                        AND u_r.onboarding_training_id = onboarding_training.id
                    ) as resultTry
                    FROM user AS u
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN user AS manager ON department.manager_id = manager.id
                    LEFT JOIN user AS business_partner ON department.business_partner_id = business_partner.id
                    LEFT JOIN division ON department.division_id = division.id
                    
                    LEFT JOIN user_onboarding_training ON u.id = user_onboarding_training.user_id
                    LEFT JOIN onboarding_training ON user_onboarding_training.onboarding_training_id = onboarding_training.id
                    LEFT JOIN onboarding ON onboarding_training.onboarding_id =  onboarding.id
                    LEFT JOIN training ON onboarding_training.training_id = training.id
                    WHERE u.block = FALSE 
                    AND training.type_of_training != :trainingPause" . $condition,
            [
                'name' => "%" . ($name ? strtolower($name) : '') . "%",
                'surname' => "%" . strtolower($surname) . "%",
                'department' => $department,
                'manager' => $user->getId(),
                'division' => $user->getDepartment()->getDivision()->getId(),
                'userId' => $userId,
                'trainingPause' => TypeOfTraining::TYPE_OF_TRAINING_PAUSE
            ],
            function (array $result) {
                return new ExportDataUserSearch(
                    (int)$result['userId'],
                    (string)$result['userName'],
                    (string)$result['userSurname'],
                    (string)$result['userLogin'],
                    $result['managerName'],
                    $result['managerSurname'],
                    $result['businessPartnerName'],
                    $result['businessPartnerSurname'],
                    (string)$result['department'],
                    $result['onboardingDay'] ? new \DateTime($result['onboardingDay']) : null,
                    $result['training'],
                    $result['resultScore'],
                    $result['resultDate'] ? new \DateTime($result['resultDate']) : null,
                    $result['resultTry']
                );
            }
        );
    }

    public function numberOfParticipants(string $dateStart, string $dateEnd, bool $isDivision, Division $division)
    {
        $condition = '';
        if (!$isDivision) $condition = ' AND (division.id = :division OR division.id IS NULL)';

        $onboardings = $this->connection->project(
            "SELECT
                    onboarding.id AS id,
                    onboarding.days AS days,
                    COUNT(u.id) AS users
                    FROM onboarding
                    LEFT JOIN user AS u ON onboarding.id = u.onboarding_id
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN division ON department.division_id = division.id
                    WHERE STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y') BETWEEN STR_TO_DATE(:dateStart, '%d.%m.%Y') AND STR_TO_DATE(:dateEnd, '%d.%m.%Y')
                    " . $condition . "
                    GROUP BY onboarding.id
                    ORDER BY STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y') ASC",
            [
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'division' => $division->getId()
            ],
            function (array $result) {
                return new NumberOfParticipants(
                    (int)$result['id'],
                    unserialize($result['days']),
                    (int)$result['users']
                );
            }
        );

        $labels = [];
        $data = [];

        /**
         * @var NumberOfParticipants $onboarding
         */
        foreach ($onboardings as $onboarding) {
            $labels[] = [
                "Onboarding " . $onboarding->getOnboardingId(),
                $onboarding->getDateStart()->format('d.m.Y')
            ];
            $data[] = $onboarding->getCountUsers();
        }

        return ["labels" => $labels, "data" => $data];
    }

    public function evaluationSurveyChart(int $onboardingId, string $question, Division $division)
    {
        $answers = $this->connection->project(
            "SELECT
                    user_answer_questionnaire.question AS question,
                    user_answer_questionnaire.answers AS answers,
                    user_answer_questionnaire.question_type AS questionType
                    FROM user_answer_questionnaire
                    LEFT JOIN user_result ON user_answer_questionnaire.user_result_id = user_result.id
                    LEFT JOIN user AS u ON user_result.user_id = u.id
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN division ON department.division_id = division.id
                    LEFT JOIN onboarding_training ON user_result.onboarding_training_id = onboarding_training.id
                    LEFT JOIN onboarding ON onboarding_training.onboarding_id = onboarding.id
                    WHERE onboarding.id = :onboardingId
                    AND user_answer_questionnaire.question = :question
                    AND division.id = :division",
            [
                'onboardingId' => $onboardingId,
                'question' => $question,
                'division' => $division->getId()
            ],
            function (array $result) {
                return new EvaluationSurveyChart(
                    (string)$result['question'],
                    unserialize($result['answers']),
                    (string)$result['questionType']
                );
            }
        );

        if (!$answers)
            return [];

        $checkType = reset($answers);

        if (array_key_exists('choices', $checkType->getAnswers())) {
            $result = [
                'Bardzo dobrze' => 0,
                'Dobrze' => 0,
                'Przeciętnie' => 0,
                'Źle' => 0,
                'Bardzo źle' => 0
            ];
        } else {
            $result = [
                'Tak' => 0,
                'Nie' => 0
            ];
        }

        /**
         * @var EvaluationSurveyChart $answer
         */
        foreach ($answers as $answer) {
            $result[$answer->getAnswerValue()] += 1;
        }

        return $result;
    }

    public function evaluationSurveyExport(string $dateStart, string $dateEnd, Division $division)
    {
        return $this->connection->project(
            "SELECT
                    user_answer_questionnaire.question AS question,
                    user_answer_questionnaire.question_type AS questionType,
                    user_answer_questionnaire.answers AS answers,
                    user_result.id AS userResultId
                    FROM user_answer_questionnaire
                    LEFT JOIN user_result ON user_answer_questionnaire.user_result_id = user_result.id
                    LEFT JOIN onboarding_training ON user_result.onboarding_training_id = onboarding_training.id
                    LEFT JOIN onboarding ON onboarding_training.onboarding_id = onboarding.id
                    LEFT JOIN user AS u ON user_result.user_id = u.id
                    LEFT JOIN department ON u.department_id = department.id
                    LEFT JOIN division ON department.division_id = division.id
                    WHERE STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(onboarding.days,';',3),':',-1),2,10), '%d.%m.%Y') BETWEEN STR_TO_DATE(:dateStart, '%d.%m.%Y') AND STR_TO_DATE(:dateEnd, '%d.%m.%Y')
                    AND division.id = :division",
            [
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'division' => $division->getId()
            ],
            function (array $result) {
                return new EvaluationSurveyExport(
                    (string)$result['question'],
                    (string)$result['questionType'],
                    unserialize($result['answers']),
                    (int)$result['userResultId']
                );
            }
        );
    }
}