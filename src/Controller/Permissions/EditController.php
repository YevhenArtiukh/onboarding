<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:59
 */

namespace App\Controller\Permissions;


use App\Entity\Permissions\Permission;
use App\Entity\Permissions\UseCase\EditPermission;
use App\Entity\Permissions\UseCase\EditPermission\Responder;
use App\Form\Permissions\EditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Permission $permission
     * @param EditPermission $editPermission
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/permission/{permission}/edit", name="permission_edit", methods={"GET", "POST"})
     * @IsGranted("permission_edit")
     */
    public function index(Request $request, Permission $permission, EditPermission $editPermission)
    {
        $form = $this->createForm(
            EditType::class,
            $permission
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditPermission\Command(
                (int) $data->getId(),
                (string) $data->getName(),
                (string) $data->getFunction()
            );
            $command->setResponder($this);

            $editPermission->execute($command);

            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('permissions');
        }

        return $this->render('permissions/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function permissionNotFound()
    {
        $this->addFlash('error', 'Podane uprawnienie nie istnieje');
    }

    public function permissionEdited()
    {
        $this->addFlash('success', 'Uprawnienie zostało zmienione');
    }

    public function functionExists()
    {
        $this->addFlash('error', 'Uprawnienie z wpisaną funkcją już istnieje');
    }
}