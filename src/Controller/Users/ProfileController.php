<?php


namespace App\Controller\Users;


use App\Adapter\Users\UploadedImage;
use App\Entity\Users\UseCase\ChangePhotoUser;
use App\Entity\Users\User;
use App\Form\Users\ChangePhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users\UseCase\ChangePhotoUser\Responder;

class ProfileController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param ChangePhotoUser $changePhotoUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/my-profile", name="user_profile", methods={"GET|POST"})
     */
    public function index(Request $request, ChangePhotoUser $changePhotoUser)
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(
            ChangePhotoType::class
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new ChangePhotoUser\Command(
                $user,
                $data['photo'] ? new UploadedImage(
                    $data['photo'],
                    $this->getParameter('user_photo_dir')
                ):null
            );
            $command->setResponder($this);

            $changePhotoUser->execute($command);

            return $this->redirectToRoute('user_profile');
        }



        return $this->render('users/profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}