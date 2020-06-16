<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-22
 * Time: 17:53
 */

namespace App\Controller\OnboardingTrainings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTraining;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTraining\Responder;
use App\Entity\Trainings\Training;
use App\Form\OnboardingTrainings\AddType;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddGeneralController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @param CreateOnboardingTraining $createOnboardingTraining
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/training/general/add", name="onboarding_training_general_add", methods={"GET", "POST"})
     */
    public function index(Request $request, Onboarding $onboarding, CreateOnboardingTraining $createOnboardingTraining)
    {
        $form = $this->createForm(
            AddType::class,
            [],
            [
                'range' => range(1, count($onboarding->getDays())),
                'status' => Onboarding\Status::STATUS_GENERAL,
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
                null,
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

    public function onboardingTrainingCreated()
    {
        $this->addFlash('success', 'Szkolenie zostało dodane do onboardingu');
    }

    public function conflictTrainings()
    {
        $this->addFlash('error', 'Nie można dodać szkolenia, ponieważ ta godzina jest już zajęta przez inne szkolenie');
    }
}