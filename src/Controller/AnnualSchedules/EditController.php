<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 14:09
 */

namespace App\Controller\AnnualSchedules;


use App\Entity\AnnualSchedules\AnnualSchedule;
use App\Entity\AnnualSchedules\UseCase\EditAnnualSchedule;
use App\Entity\AnnualSchedules\UseCase\EditAnnualSchedule\Responder;
use App\Entity\Divisions\Division;
use App\Form\AnnualSchedules\EditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param AnnualSchedule $annualSchedule
     * @param EditAnnualSchedule $editAnnualSchedule
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/annual-schedule/{annualSchedule}/edit", name="annual_schedule_edit", methods={"GET", "POST"})
     * @IsGranted("annual_schedules_action")
     */
    public function index(Request $request, AnnualSchedule $annualSchedule, EditAnnualSchedule $editAnnualSchedule)
    {
        $form = $this->createForm(
            EditType::class,
            $this->transformData($annualSchedule)
        );
        $form->handleRequest($request);

        $this->transformData($annualSchedule);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditAnnualSchedule\Command(
                $annualSchedule,
                new \DateTime($data['dateStart']),
                new \DateTime($data['dateEnd']),
                $data['days']
            );
            $command->setResponder($this);

            $editAnnualSchedule->execute($command);

            return $this->redirectToRoute('annual_schedules');
        }

        return $this->render('annual_schedules/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function transformData(AnnualSchedule $annualSchedule)
    {
        foreach ($annualSchedule->getDays() as $day) {
            $days[] = [
                'division' => $this->getDoctrine()->getRepository(Division::class)->findOneBy(['id'=>$day['division']->getId()]),
                'dateStart' => $day['dateStart'],
                'dateEnd' => $day['dateEnd']
            ];
        }
        return [
            'dateStart' => $annualSchedule->getDateStart()->format('d.m.Y'),
            'dateEnd' => $annualSchedule->getDateEnd()->format('d.m.Y'),
            'days' => $days??[]
        ];
    }
}