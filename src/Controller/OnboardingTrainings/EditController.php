<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:11
 */

namespace App\Controller\OnboardingTrainings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\UseCase\EditOnboardingTraining;
use App\Entity\OnboardingTrainings\UseCase\EditOnboardingTraining\Responder;
use App\Entity\Trainings\Training;
use App\Form\OnboardingTrainings\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @param OnboardingTraining $onboardingTraining
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/training/{onboardingTraining}/edit", name="onboarding_training_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, Onboarding $onboarding, OnboardingTraining $onboardingTraining, EditOnboardingTraining $editOnboardingTraining)
    {
        $form = $this->createForm(
            EditType::class,
            $this->transformData($onboardingTraining),
            [
                'range' => $this->generateRangeDaysTraining($onboarding, $onboardingTraining),
                'status' => $onboardingTraining->getTraining()->getKindOfTraining(),
                'division' => $this->getUser()->getDepartment()->getDivision()->getId(),
                'trainingRepository' => $this->getDoctrine()->getRepository(Training::class),
                'typeOfTraining' => $onboardingTraining->getTraining()->getTypeOfTraining()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditOnboardingTraining\Command(
                (int)$onboardingTraining->getId(),
                $onboarding,
                $data['training'],
                ($onboarding->getStatus() === Onboarding\Status::STATUS_GENERAL)?null:$this->getUser()->getDepartment()->getDivision(),
                $data['coaches'],
                (string)$data['type'],
                new \DateTime($data['time']),
                (int)$data['day']
            );
            $command->setResponder($this);

            $editOnboardingTraining->execute($command);

            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        return $this->render('onboarding_trainings/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function transformData(OnboardingTraining $onboardingTraining)
    {
        return [
            'training' => $onboardingTraining->getTraining(),
            'coaches' => $onboardingTraining->getCoaches(),
            'type' => $onboardingTraining->getType(),
            'time' => $onboardingTraining->getTime()->format('H:i'),
            'day' => $onboardingTraining->getDay()
        ];
    }

    private function generateRangeDaysTraining(Onboarding $onboarding, OnboardingTraining $onboardingTraining)
    {
        if($onboardingTraining->getTraining()->getKindOfTraining() === Onboarding\Status::STATUS_GENERAL) {
            $range = range(1, count($onboarding->getDays()));
        } elseif ($onboardingTraining->getTraining()->getKindOfTraining() === Onboarding\Status::STATUS_DIVISION) {
            foreach ($onboarding->getOnboardingDivisions() as $onboardingDivision) {
                if($onboardingDivision->getDivision() === $this->getUser()->getDepartment()->getDivision()) {
                    $start = (int)date_diff(date_create($onboardingDivision->getDays()[0]['day']), date_create($onboarding->getDays()[0]['day']))->format('%d');
                    $end = $start + count($onboardingDivision->getDays());
                    $range = range($start+1, $end);
                }
            }
        }

        return $range;
    }

    public function onboardingTrainingNotFound()
    {
        $this->addFlash('error', 'Podane szkolenie nie istnieje');
    }

    public function onboardingTrainingEdited()
    {
        $this->addFlash('success', 'Szkolenie zostało zmienione');
    }

    public function conflictTrainings()
    {
        $this->addFlash('error', 'Nie można zapisać, godzine już zajęte');
    }
}