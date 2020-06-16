<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 9:38
 */

namespace App\Controller\Security;


use App\Entity\Users\UseCase\PasswordReset;
use App\Entity\Users\UseCase\PasswordReset\Responder;
use App\Form\Security\PasswordResetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PasswordResetController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/password-reset", name="password_reset", methods={"GET", "POST"})
     */
    public function index(Request $request, PasswordReset $passwordReset)
    {
        if ($this->getUser()) return $this->redirectToRoute('dashboard');

        $form = $this->createForm(
            PasswordResetType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new PasswordReset\Command(
                (string) $data['email']
            );
            $command->setResponder($this);

            $passwordReset->execute($command);

            return $this->redirectToRoute('login');
        }

        return $this->render('security/password_reset.html.twig', [
            'form' => $form->createView()
        ]);
    }
}