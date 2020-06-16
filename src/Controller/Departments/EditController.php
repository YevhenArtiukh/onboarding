<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 18:01
 */

namespace App\Controller\Departments;


use App\Entity\Departments\Department;
use App\Entity\Departments\UseCase\EditDepartment;
use App\Entity\Departments\UseCase\EditDepartment\Responder;
use App\Entity\Divisions\Division;
use App\Form\Departments\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Department $department
     * @param EditDepartment $editDepartment
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/{division}/department/{department}/edit", name="department_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, Division $division, Department $department, EditDepartment $editDepartment)
    {
        $form = $this->createForm(
            EditType::class,
            $department,
            [
                'division' => $this->getUser()->getDepartment()->getDivision(),
                'department' => $department
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditDepartment\Command(
                (int)$department->getId(),
                (string)$data->getName(),
                $data->getParent(),
                $data->getManager(),
                $data->getBusinessPartner()
            );
            $command->setResponder($this);

            $editDepartment->execute($command);

            if ($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('departments', ['division' => $division->getId()]);
        }

        return $this->render('departments/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function departmentNotFound()
    {
        $this->addFlash('error', 'Podany obszar nie istnieje');
    }

    public function departmentEdited()
    {
        $this->addFlash('success', 'Obszar został zmieniony');
    }

    public function departmentFirstLevelExists()
    {
        $this->addFlash('error', 'Obszar na poziomie pierwszym już istnieje');
    }

    public function errorBuildTree()
    {
        $this->addFlash('error', 'Nie można zrobić zmianę');
    }
}