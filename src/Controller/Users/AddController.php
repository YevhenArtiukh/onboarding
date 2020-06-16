<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:18
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\CreateUser;
use App\Entity\Users\UseCase\CreateUser\Responder;
use App\Form\Users\AddType;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateUser $createUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/user/add", name="user_add", methods={"GET", "POST"})
     * @IsGranted("user_add")
     */
    public function index(Request $request, CreateUser $createUser)
    {
        $form = $this->createForm(
            AddType::class,
            [],
            [
                'division' => $this->getUser()->getDepartment()->getDivision()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateUser\Command(
                (string) $data['name'],
                (string) $data['surname'],
                (string) $data['email'],
                $data['department'],
                (string) $data['identifier'],
                new \DateTime($data['date']),
                (string) $data['position'],
                (string) $data['formOfEmployment'],
                (string) $data['typeOfWorker'],
                $data['roles']
            );
            $command->setResponder($this);

            $createUser->execute($command);

            return $this->redirectToRoute('users');
        }

        return $this->render('users/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function userCreated()
    {
        $this->addFlash('success', 'Użytkownik został stworzony');
    }

    public function emailExists()
    {
        $this->addFlash('error', 'Wpisany e-mail już istnieje');
    }
}