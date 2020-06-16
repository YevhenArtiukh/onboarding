<?php


namespace App\Controller\Users;


use App\Entity\Users\UseCase\AnonymizationUser;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users\UseCase\AnonymizationUser\Responder;
use Symfony\Component\Routing\Annotation\Route;

class AnonymizationController extends AbstractController implements Responder
{
    /**
     * @Route("/user/{user}/anon", name="user_anon", methods={"POST"})
     * @param User $user
     * @param AnonymizationUser $anonymizationUser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Throwable
     */
    public function index(User $user, AnonymizationUser $anonymizationUser)
    {
        $command = new AnonymizationUser\Command(
            $user->getId()
        );
        $command->setResponder($this);

        $anonymizationUser->execute($command);

        return $this->redirectToRoute('user_show', [
            'user' => $user->getId()
        ]);
    }
}