<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 13:30
 */

namespace App\Controller\AnnualSchedules;


use App\Entity\AnnualSchedules\AnnualSchedule;
use App\Entity\AnnualSchedules\UseCase\DeleteAnnualSchedule;
use App\Entity\AnnualSchedules\UseCase\DeleteAnnualSchedule\Responder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param AnnualSchedule $annualSchedule
     * @param DeleteAnnualSchedule $deleteAnnualSchedule
     * @return JsonResponse
     * @throws \Throwable
     * @Route("/annual-schedule/{annualSchedule}/delete", name="annual_schedule_delete", methods={"DELETE"})
     * @IsGranted("annual_schedules_action")
     */
    public function index(Request $request, AnnualSchedule $annualSchedule, DeleteAnnualSchedule $deleteAnnualSchedule)
    {
        if ($this->isCsrfTokenValid('delete'.$annualSchedule->getId(), $request->request->get('_token'))) {

            $command = new DeleteAnnualSchedule\Command(
                $annualSchedule
            );
            $command->setResponder($this);

            $deleteAnnualSchedule->execute($command);

            return new JsonResponse('success');
        }

        return new JsonResponse('Csrf token is not Valid', 400);
    }
}