<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:32
 */

namespace App\Controller\Roles;


use App\Entity\Roles\Role;
use App\Entity\Roles\UseCase\EditRole;
use App\Entity\Roles\UseCase\EditRole\Responder;
use App\Form\Roles\EditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Role $role
     * @param EditRole $editRole
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/role/{role}/edit", name="role_edit", methods={"GET", "POST"})
     * @IsGranted("role_edit")
     */
    public function index(Request $request, Role $role, EditRole $editRole)
    {
        $form = $this->createForm(
            EditType::class,
            $role
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditRole\Command(
                (int) $data->getId(),
                (string) $data->getName(),
                $data->getPermissions()
            );
            $command->setResponder($this);

            $editRole->execute($command);

            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('roles');
        }

        return $this->render('roles/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function roleNotFound()
    {
        $this->addFlash('error', 'Podana rola nie istnieje');
    }

    public function roleEdited()
    {
        $this->addFlash('success', 'Role została zmieniona');
    }

    public function roleNameExists()
    {
        $this->addFlash('error', 'Rola z wpisaną nazwą już istnieje');
    }
}