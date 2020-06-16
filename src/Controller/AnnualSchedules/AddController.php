<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-13
 * Time: 15:29
 */

namespace App\Controller\AnnualSchedules;


use App\Entity\AnnualSchedules\UseCase\CreateAnnualSchedule;
use App\Entity\AnnualSchedules\UseCase\CreateAnnualSchedule\Responder;
use App\Form\AnnualSchedules\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateAnnualSchedule $createAnnualSchedule
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/annual-schedule/add", name="annual_schedule_add", methods={"GET", "POST"})
     * @IsGranted("annual_schedules_action")
     */
    public function index(Request $request, CreateAnnualSchedule $createAnnualSchedule)
    {
        $form = $this->createForm(AddType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateAnnualSchedule\Command(
                new \DateTime($data['dateStart']),
                new \DateTime($data['dateEnd']),
                $data['days']
            );
            $command->setResponder($this);

            $createAnnualSchedule->execute($command);

            return $this->redirectToRoute('annual_schedules');
        }

        return $this->render('annual_schedules/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}