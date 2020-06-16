<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 10:51
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\ChangePassword;
use App\Entity\Users\User;
use App\Form\Users\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users\UseCase\ChangePassword\Responder;

class ShowController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param User $user
     * @param ChangePassword $changePassword
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/user/{user}", name="user_show", methods={"GET|POST"})
     */
    public function index(Request $request, User $user, ChangePassword $changePassword)
    {
        $formEditPassword = $this->createForm(
            ChangePasswordType::class
        );
        $formEditPassword->handleRequest($request);

        if ($formEditPassword->isSubmitted() && $formEditPassword->isValid()) {
            $data = $formEditPassword->getData();

            $command = new ChangePassword\Command(
                $user,
                $data['password']
            );
            $command->setResponder($this);

            $changePassword->execute($command);

            $this->redirectToRoute('user_show', ['user' => $user->getId()]);

        }
        return $this->render('users/show.html.twig', [
            'user' => $user,
            'formEditPassword' => $formEditPassword->createView()
        ]);
    }
}