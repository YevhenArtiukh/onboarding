<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 12:12
 */

namespace App\Controller\OnboardingTrainings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTraining;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTraining\Responder;
use App\Entity\Trainings\Training;
use App\Form\OnboardingTrainings\AddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddDivisionController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/training/division/add", name="onboarding_training_division_add", methods={"GET", "POST"})
     */
    public function index(Request $request, Onboarding $onboarding, CreateOnboardingTraining $createOnboardingTraining)
    {
        if (!$this->isGranted('onboarding_training_add_general') && !$this->isGranted('onboarding_training_add_division'))
            throw $this->createAccessDeniedException();

        $form = $this->createForm(
            AddType::class,
            [],
            [
                'range' => $this->generateRangeDaysTraining($onboarding),
                'status' => Onboarding\Status::STATUS_DIVISION,
                'division' => $this->getUser()->getDepartment()->getDivision()->getId(),
                'trainingRepository' => $this->getDoctrine()->getRepository(Training::class)
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateOnboardingTraining\Command(
                $onboarding,
                $data['training'],
                $this->getUser()->getDepartment()->getDivision(),
                (int)$data['day'],
                new \DateTime($data['time']),
                $data['coaches']??null,
                $data['type']??null
            );
            $command->setResponder($this);

            $createOnboardingTraining->execute($command);

            if ($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        return $this->render('onboarding_trainings/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function generateRangeDaysTraining(Onboarding $onboarding)
    {
        foreach ($onboarding->getOnboardingDivisions() as $onboardingDivision) {
            if ($onboardingDivision->getDivision() === $this->getUser()->getDepartment()->getDivision()) {
                $start = (int)date_diff(date_create($onboardingDivision->getDays()[0]['day']), date_create($onboarding->getDays()[0]['day']))->format('%d');
                $end = $start + count($onboardingDivision->getDays());
                $range = range($start + 1, $end);
            }
        }

        return $range??[];
    }

    public function onboardingTrainingCreated()
    {
        $this->addFlash('success', 'Szkolenie zostało dodane do onboardingu');
    }

    public function conflictTrainings()
    {
        $this->addFlash('error', 'Nie można dodać szkolenia, ponieważ ta godzina jest już zajęta przez inne szkolenie');
    }
}