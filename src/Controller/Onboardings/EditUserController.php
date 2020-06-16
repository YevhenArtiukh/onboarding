<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-16
 * Time: 11:47
 */

namespace App\Controller\Onboardings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\UseCase\EditUserOnboarding;
use App\Entity\Onboardings\UseCase\EditUserOnboarding\Responder;
use App\Entity\Users\User;
use App\Form\Onboardings\EditUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditUserController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/user/{user}/edit", name="onboarding_user_edit", methods={"GET", "POST"})
     * @IsGranted("onboarding_training_add_division")
     */
    public function index(Request $request, Onboarding $onboarding, User $user, EditUserOnboarding $editUserOnboarding)
    {
        if ($user->getOnboarding() !== $onboarding or $user->getDepartment()->getDivision() !== $this->getUser()->getDepartment()->getDivision())
            throw $this->createNotFoundException();

        $form = $this->createForm(
            EditUserType::class,
            $this->transformData($user),
            [
                'division' => $user->getDepartment()->getDivision()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditUserOnboarding\Command(
                (int)$user->getId(),
                (string)$data['name'],
                (string)$data['surname'],
                (string)$data['email'],
                $data['identifier'],
                $data['department'],
                (string)$data['position'],
                (string)$data['formOfEmployment'],
                (string)$data['typeOfWorker'],
                $data['roles']
            );
            $command->setResponder($this);

            $editUserOnboarding->execute($command);

            if ($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        return $this->render('onboardings/edit_user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function transformData(User $user)
    {
        return [
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail(),
            'identifier' => $user->getIdentifier(),
            'department' => $user->getDepartment(),
            'position' => $user->getPosition(),
            'division' => $user->getDepartment()->getDivision(),
            'formOfEmployment' => $user->getFormOfEmployment(),
            'typeOfWorker' => $user->getTypeOfWorker(),
            'roles' => $user->getRolesEntity()
        ];
    }

    public function userNotFound()
    {
        $this->addFlash('error', 'Pracownik nie istnieje');
    }

    public function userEdited()
    {
        $this->addFlash('success', 'Dane pracownika zmienione');
    }
}