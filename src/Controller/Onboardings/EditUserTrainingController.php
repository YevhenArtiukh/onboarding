<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 14:20
 */

namespace App\Controller\Onboardings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\UseCase\EditUserTrainingOnboarding;
use App\Entity\Onboardings\UseCase\EditUserTrainingOnboarding\Responder;
use App\Entity\Users\User;
use App\Form\Onboardings\EditUserTrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditUserTrainingController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @param User $user
     * @param EditUserTrainingOnboarding $editUserTrainingOnboarding
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/user/{user}/training/edit", name="onboarding_user_training_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, Onboarding $onboarding, User $user, EditUserTrainingOnboarding $editUserTrainingOnboarding)
    {
        $form = $this->createForm(
            EditUserTrainingType::class,
            [
                'onboardingTrainings' => $user->getOnboardingTrainings()
            ],
            [
                'onboarding' => $onboarding,
                'division' => $user->getDepartment()->getDivision()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditUserTrainingOnboarding\Command(
                $user,
                $onboarding,
                $data['onboardingTrainings']
            );
            $command->setResponder($this);

            $editUserTrainingOnboarding->execute($command);

            return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        return $this->render('onboardings/edit_user_training.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function userTrainingEdited()
    {
        $this->addFlash('success', 'Szkolenia dla pracownika zostały zmienione');
    }
}