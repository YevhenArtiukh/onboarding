<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 18:01
 */

namespace App\Controller\Departments;

use App\Entity\Departments\UseCase\CreateDepartment;
use App\Entity\Departments\UseCase\CreateDepartment\Responder;
use App\Entity\Divisions\Division;
use App\Form\Departments\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateDepartment $createDepartment
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/{division}/department/add", name="department_add", methods={"GET", "POST"})
     * @IsGranted("department_add")
     */
    public function index(Request $request, Division $division, CreateDepartment $createDepartment)
    {
        $form = $this->createForm(
            AddType::class,
            [],
            [
                'division' => $this->getUser()->getDepartment()->getDivision()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateDepartment\Command(
                (string)$data['name'],
                $data['parent'],
                $data['manager'],
                $data['businessPartner'],
                $this->getUser()->getDepartment()->getDivision()
            );
            $command->setResponder($this);

            $createDepartment->execute($command);

            if ($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('departments', ['division' => $division->getId()]);
        }

        return $this->render('departments/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function departmentCreated(string $departmentName)
    {
        $this->addFlash('success', 'Obszar ' . $departmentName . ' został stworzony');
    }

    public function departmentFirstLevelExists()
    {
        $this->addFlash('error', 'Obszar na poziomie pierwszym już istnieje');
    }
}