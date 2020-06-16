<?php


namespace App\Controller\Migrations;


use App\Adapter\Users\ReadModel\UserMigrationQuery;
use App\Form\Migrations\MigrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FindController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserMigrationQuery $userMigrationQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/migration-find", name="migration_find", methods={"GET|POST"})
     * @IsGranted("migration")
     */
    public function index(Request $request, UserMigrationQuery $userMigrationQuery)
    {
        $form = $this->createForm(
            MigrationType::class,
            [],
            [
                'division' => $this->getUser()->getDepartment()->getDivision()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $usersData = $userMigrationQuery->findByParams($data);

            if(!$usersData)
            {
                $this->addFlash('error', 'Nie znaleziono żadnej osoby');
            }
        }

        return $this->render('migrations/find.html.twig',
        [
            'form' => $form->createView(),
            'usersData' => $usersData??null
        ]);
    }
}