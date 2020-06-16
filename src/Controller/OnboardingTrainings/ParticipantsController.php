<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 16:25
 */

namespace App\Controller\OnboardingTrainings;


use App\Adapter\OnboardingTrainings\ReadModel\ParticipantsOnboardingTrainingQuery;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\PresenceParticipants\UseCase\CoachConfirmation;
use App\Entity\PresenceParticipants\UseCase\CoachConfirmation\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantsController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param OnboardingTraining $onboardingTraining
     * @param ParticipantsOnboardingTrainingQuery $participantsOnboardingTrainingQuery
     * @param CoachConfirmation $coachConfirmation
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding-training/{onboardingTraining}/participants", name="participants_onboarding_training", methods={"GET", "POST"})
     */
    public function index(Request $request, OnboardingTraining $onboardingTraining, ParticipantsOnboardingTrainingQuery $participantsOnboardingTrainingQuery, CoachConfirmation $coachConfirmation)
    {
        if(in_array($this->getUser(), $onboardingTraining->getCoaches()->toArray()) || $this->isGranted('coaching')) {

            if ($request->isMethod('POST')) {
                $command = new CoachConfirmation\Command(
                    $onboardingTraining,
                    $request->get('id') ?? [],
                    $this->getUser()
                );
                $command->setResponder($this);

                $coachConfirmation->execute($command);

                return $this->redirectToRoute('participants_onboarding_training', ['onboardingTraining' => $onboardingTraining->getId()]);
            }

            return $this->render('onboarding_trainings/participants.html.twig', [
                'users' => $participantsOnboardingTrainingQuery->findAll($onboardingTraining)
            ]);
        } else {
            throw $this->createNotFoundException();
        }
    }

    public function confirmed()
    {
        $this->addFlash('success', 'Zmiany zostały zapisane');
    }

    public function userNotFound()
    {
        $this->addFlash('error', 'Problem ze zmianami');
    }
}