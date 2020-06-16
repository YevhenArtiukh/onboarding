<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 12:23
 */

namespace App\Controller\OnboardingTrainings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTrainingAdditional;
use App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTrainingAdditional\Responder;
use App\Form\OnboardingTrainings\AddAdditionalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddAdditionalController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @param CreateOnboardingTrainingAdditional $createOnboardingTrainingAdditional
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/training/additional/add", name="onboarding_training_add_additional", methods={"GET", "POST"})
     */
    public function index(Request $request, Onboarding $onboarding, CreateOnboardingTrainingAdditional $createOnboardingTrainingAdditional)
    {
        $form = $this->createForm(
            AddAdditionalType::class,
            [],
            [
                'status' => $onboarding->getStatus(),
                'division' => $this->getUser()->getDepartment()->getDivision()->getId()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateOnboardingTrainingAdditional\Command(
                $onboarding,
                $data['training'],
                $this->getUser()->getDepartment()->getDivision(),
                (string)$data['type'],
                $data['coaches'],
                (int)$data['day']
            );
            $command->setResponder($this);

            $createOnboardingTrainingAdditional->execute($command);

            return $this->redirectToRoute('onboarding_show', ['onboarding'=>$onboarding->getId()]);
        }

        return $this->render('onboarding_trainings/add_additional.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function onboardingTrainingCreated()
    {
        $this->addFlash('success', 'Szkolenie dodatkowe zostało dodane do onboardingu');
    }
}