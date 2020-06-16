<?php


namespace App\Adapter\Dashboard;


use App\Adapter\Dashboard\DashboardQueryByRole\CoachQuery;
use App\Adapter\Dashboard\DashboardQueryByRole\CrossPartnerQuery;
use App\Adapter\Dashboard\DashboardQueryByRole\DivisionPartnerQuery;
use App\Entity\Users\User;

class DashboardQuery
{
    private $coachQuery;
    private $crossPartnerQuery;
    private $divisionPartnerQuery;


    public function __construct(
        CoachQuery $coachQuery,
        CrossPartnerQuery $crossPartnerQuery,
        DivisionPartnerQuery $divisionPartnerQuery
    )
    {
        $this->coachQuery = $coachQuery;
        $this->crossPartnerQuery = $crossPartnerQuery;
        $this->divisionPartnerQuery = $divisionPartnerQuery;
    }

    public function valueByWidgetQuery(?string $widgetQuery, User $user)
    {
        switch ($widgetQuery):
            case 'query1':
                $result = $this->divisionPartnerQuery->countWorkersByLastOnboardingAndDivision($user);
                break;
            case 'query2':
                $result = $this->divisionPartnerQuery->countWorkersByLastOnboarding();
                break;
            case 'query3':
                $result = $this->divisionPartnerQuery->countWorkersByDivision($user);
                break;
            case 'query4':
                $result = $this->divisionPartnerQuery->countWorkersEndangeredDates($user);
                break;
            case 'query5':
                $result = $this->divisionPartnerQuery->smallChartCountWorkersAEByDivision($user);
                    break;
            case 'query6':
                $result = $this->crossPartnerQuery->countWorkersByLastOnboarding();
                break;
            case 'query7':
                $result = $this->crossPartnerQuery->countWorkers();
                break;
            case 'query8':
                $result = $this->crossPartnerQuery->smallChartCountWorkersAE();
                break;
            case 'query9':
                $result = $this->coachQuery->nearTrainings($user);
                break;
            case 'query10':
                $result = $this->coachQuery->countWorkersEndangeredDatesByCoach($user);
                break;
            case 'query11':
                $result = $this->coachQuery->smallChartCountWorkersByLastOnboardingByDivision();
                break;
            default:
                $result = [];
        endswitch;

        return $result;
    }


}