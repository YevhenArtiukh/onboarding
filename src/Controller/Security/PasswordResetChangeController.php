<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 11:13
 */

namespace App\Controller\Security;

use App\Adapter\Users\ReadModel\UserQuery;
use App\Entity\Users\UseCase\PasswordResetChange;
use App\Entity\Users\UseCase\PasswordResetChange\Responder;
use App\Form\Security\PasswordResetChangeType;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PasswordResetChangeController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/password-reset/change/{token}", name="password_reset_change", methods={"GET", "POST"})
     * @throws \Throwable
     */
    public function index(Request $request, string $token, UserQuery $userQuery, PasswordResetChange $passwordResetChange)
    {
        if(!$userQuery->passwordResetChange($token))
            throw new LogicException();

        $form = $this->createForm(
            PasswordResetChangeType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new PasswordResetChange\Command(
                (string) $token,
                (string) $data['password']
            );
            $command->setResponder($this);

            $passwordResetChange->execute($command);

            return $this->redirectToRoute('login');
        }

        return $this->render('security/password_reset_change.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function passwordEdited()
    {
        $this->addFlash('success', 'Hasło zostało zmienione');
    }
}