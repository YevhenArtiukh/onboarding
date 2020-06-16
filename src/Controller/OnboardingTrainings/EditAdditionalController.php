<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 12:58
 */

namespace App\Controller\OnboardingTrainings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\UseCase\EditOnboardingTrainingAdditional;
use App\Entity\OnboardingTrainings\UseCase\EditOnboardingTrainingAdditional\Responder;
use App\Form\OnboardingTrainings\EditAdditionalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditAdditionalController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @param OnboardingTraining $onboardingTraining
     * @param EditOnboardingTrainingAdditional $editOnboardingTrainingAdditional
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/training/{onboardingTraining}/additional/edit", name="onboarding_training_edit_additional", methods={"GET", "POST"})
     */
    public function index(Request $request, Onboarding $onboarding, OnboardingTraining $onboardingTraining, EditOnboardingTrainingAdditional $editOnboardingTrainingAdditional)
    {
        $form = $this->createForm(
            EditAdditionalType::class,
            $onboardingTraining,
            [
                'status' => $onboarding->getStatus(),
                'division' => $this->getUser()->getDepartment()->getDivision()->getId()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditOnboardingTrainingAdditional\Command(
                (int)$onboardingTraining->getId(),
                $data->getTraining(),
                $data->getCoaches(),
                (string)$data->getType(),
                (int)$data->getDay()
            );
            $command->setResponder($this);

            $editOnboardingTrainingAdditional->execute($command);

            if ($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        return $this->render('onboarding_trainings/edit_additional.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function onboardingTrainingNotFound()
    {
        $this->addFlash('error', 'Podane szkolenie nie istnieje');
    }

    public function onboardingTrainingEdited()
    {
        $this->addFlash('success', 'Szkolenie zostało zmienione');
    }
}