<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:39
 */

namespace App\Controller\OnboardingTrainings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\OnboardingTrainings\UseCase\DeleteOnboardingTraining;
use App\Entity\OnboardingTrainings\UseCase\DeleteOnboardingTraining\Responder;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @param OnboardingTraining $onboardingTraining
     * @param DeleteOnboardingTraining $deleteOnboardingTraining
     * @return JsonResponse
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/training/{onboardingTraining}/delete", name="onboarding_training_delete", methods={"DELETE"})
     */
    public function index(Request $request, Onboarding $onboarding, OnboardingTraining $onboardingTraining, DeleteOnboardingTraining $deleteOnboardingTraining)
    {
        if ($this->isCsrfTokenValid('delete'.$onboardingTraining->getId(), $request->request->get('_token'))) {

            $command = new DeleteOnboardingTraining\Command(
                (int) $onboardingTraining->getId()
            );
            $command->setResponder($this);

            $deleteOnboardingTraining->execute($command);

            return new JsonResponse('success');
        }

        return new JsonResponse('Csrf token is not Valid', 400);
    }

    public function onboardingTrainingNotFound()
    {
        $this->addFlash('error', 'Szkolenie nie istnije');
    }

    public function onboardingTrainingDeleted()
    {
        $this->addFlash('success', 'Szkolenie zostało usunięte');
    }
}