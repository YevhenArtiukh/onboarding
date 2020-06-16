<?php


namespace App\Controller\Migrations;


use App\Adapter\Users\ReadModel\UserMigrationQuery;
use App\Entity\Users\UseCase\MigrateUser;
use App\Entity\Users\User;
use App\Form\Migrations\MigrationUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users\UseCase\MigrateUser\Responder;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param User $user
     * @param MigrateUser $migrateUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/migration/{user}", name="migration_show", methods={"GET|POST"})
     * @throws \Throwable
     */
    public function index(Request $request, User $user, MigrateUser $migrateUser)
    {
        $form = $this->createForm(
            MigrationUserType::class,
                $this->getTransformData($user)
            ,
            [
                'division' => $this->getUser()->getDepartment()->getDivision()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new MigrateUser\Command(
                $user,
                $data['department'],
                $data['position'],
                $data['formOfEmployment'],
                $data['typeOfWorker'],
                $data['email']
            );
            $command->setResponder($this);

            $migrateUser->execute($command);

            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('users');
        }


        return $this->render('migrations/show.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    private function getTransformData(User $user)
    {
        return [
            'position' => $user->getPosition(),
            'formOfEmployment' => $user->getFormOfEmployment(),
            'typeOfWorker' => $user->getTypeOfWorker(),
            'email' => $user->getEmail()
        ];
    }

    public function userMigrated()
    {
        $this->addFlash('success', 'Migracja udana');
    }

    public function userWithEmailExist()
    {
        $this->addFlash('error', 'Osoba o takim email już istnieje');
    }
}