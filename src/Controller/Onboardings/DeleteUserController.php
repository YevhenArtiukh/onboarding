<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 14:32
 */

namespace App\Controller\Onboardings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\UseCase\DeleteUserOnboarding;
use App\Entity\Onboardings\UseCase\DeleteUserOnboarding\Responder;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUserController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param User $user
     * @param Onboarding $onboarding
     * @param DeleteUserOnboarding $deleteUserOnboarding
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/user/{user}/delete", name="onboarding_delete_user", methods={"DELETE"})
     */
    public function index(Request $request, User $user, Onboarding $onboarding, DeleteUserOnboarding $deleteUserOnboarding)
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            $command = new DeleteUserOnboarding\Command(
                $user
            );
            $command->setResponder($this);

            $deleteUserOnboarding->execute($command);
        }

        return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
    }

    public function userDeleted()
    {
        $this->addFlash('success', 'Osoba została usunięta z onboardingu');
    }
}