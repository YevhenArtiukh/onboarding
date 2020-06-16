<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 16:49
 */

namespace App\Controller\Users;

use App\Adapter\Users\UploadedImage;
use App\Entity\Users\UseCase\FirstLoginUser;
use App\Entity\Users\UseCase\FirstLoginUser\Responder;
use App\Form\Users\FirstLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FirstLoginController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param FirstLoginUser $firstLoginUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/first-login", name="first_login", methods={"GET", "POST"})
     */
    public function index(Request $request, FirstLoginUser $firstLoginUser)
    {
        if($this->getUser()->getActive())
            return $this->redirectToRoute('dashboard');

        $form = $this->createForm(
            FirstLoginType::class,
            [],
            [
                'roles' => $this->getUser()->getRoles()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new FirstLoginUser\Command(
                $this->getUser()->getId(),
                (string) $data['password'],
                $data['role']??$this->getUser()->getRolesEntity()[0],
                $data['photo'] ? new UploadedImage(
                    $data['photo'],
                    $this->getParameter('user_photo_dir')
                ):null
            );
            $command->setResponder($this);

            $firstLoginUser->execute($command);
            if($this->getUser()->getCurrentRole()->getName() == "Pracownik" || $this->getUser()->getCurrentRole()->getName() == "Manager")
                return $this->redirectToRoute('training_schedule_general');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('users/first_login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}