<?php


namespace App\Controller\Users;


use App\Entity\Users\UseCase\EditUser;
use App\Entity\Users\UseCase\EditUser\Responder;
use App\Entity\Users\User;
use App\Form\Users\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param User $user
     * @param EditUser $editUser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/user/{user}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, User $user, EditUser $editUser)
    {
        $form = $this->createForm(
            EditType::class,
            $this->transformData($user),
            [
                'division' => $user->getDepartment()->getDivision()
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditUser\Command(
                $user,
                (string)$data['name'],
                (string)$data['surname'],
                (string)$data['email'],
                $data['department'],
                (string)$data['identifier'],
                new \DateTime($data['date']),
                (string)$data['position'],
                (string)$data['formOfEmployment'],
                (string)$data['typeOfWorker'],
                $data['roles']
            );
            $command->setResponder($this);

            $editUser->execute($command);

            return $this->redirectToRoute('users');
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function transformData(User $user)
    {
        return [
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail(),
            'identifier' => $user->getIdentifier(),
            'date' => $user->getDateOfEmployment()->format('d.m.Y'),
            'formOfEmployment' => $user->getFormOfEmployment(),
            'position' => $user->getPosition(),
            'department' => $user->getDepartment(),
            'typeOfWorker' => $user->getTypeOfWorker(),
            'roles' => $user->getRolesEntity()
        ];
    }

    public function userEdited()
    {
         $this->addFlash('success','Użytkownik został zmieniony');
    }
}

