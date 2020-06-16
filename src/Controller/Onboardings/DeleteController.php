<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 17:22
 */

namespace App\Controller\Onboardings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\UseCase\DeleteOnboarding;
use App\Entity\Onboardings\UseCase\DeleteOnboarding\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @param DeleteOnboarding $deleteOnboarding
     * @return JsonResponse
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/delete", name="onboarding_delete", methods={"DELETE"})
     */
    public function index(Request $request, Onboarding $onboarding, DeleteOnboarding $deleteOnboarding)
    {
        if ($this->isCsrfTokenValid('delete'.$onboarding->getId(), $request->request->get('_token'))) {

            $command = new DeleteOnboarding\Command(
                (int) $onboarding->getId()
            );
            $command->setResponder($this);

            $deleteOnboarding->execute($command);

            return new JsonResponse('success');
        }

        return new JsonResponse('Csrf token is not Valid', 400);
    }

    public function onboardingNotFound()
    {
        $this->addFlash('error', 'Onboarding nie istnije');
    }

    public function onboardingDeleted()
    {
        $this->addFlash('success', 'Onboarding został usunięty');
    }
}