<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 13:07
 */

namespace App\Controller\PresenceParticipants;


use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\PresenceParticipants\UseCase\UserConfirmation;
use App\Entity\PresenceParticipants\UseCase\UserConfirmation\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserConfirmationController extends AbstractController implements Responder
{
    /**
     * @Route("/onboarding-training/{onboardingTraining}/confirmation", name="user_confirmation", methods={"POST"})
     */
    public function index(OnboardingTraining $onboardingTraining, UserConfirmation $userConfirmation)
    {
        if ($onboardingTraining->isTypeTest())
            return $this->createNotFoundException();

        $command = new UserConfirmation\Command(
            $onboardingTraining,
            $this->getUser()
        );
        $command->setResponder($this);

        $userConfirmation->execute($command);

        return new JsonResponse('test');
    }

    public function confirmed()
    {
        $this->addFlash('success', 'Udział potwierdzony');
    }
}