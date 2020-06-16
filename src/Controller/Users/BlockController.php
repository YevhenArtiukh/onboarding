<?php


namespace App\Controller\Users;


use App\Entity\Users\UseCase\BlockUser;
use App\Entity\Users\User;
use App\Entity\Users\UseCase\BlockUser\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlockController extends AbstractController implements Responder
{
    /**
     * @param User $user
     * @param BlockUser $blockUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/user/{user}/block", name="user_block", methods={"POST"})
     */
    public function index(User $user, BlockUser $blockUser)
    {
        $command = new BlockUser\Command(
            $user->getId()
        );
        $command->setResponder($this);

        $blockUser->execute($command);

        return $this->redirectToRoute('user_show', [
            'user' => $user->getId()
        ]);
    }
}