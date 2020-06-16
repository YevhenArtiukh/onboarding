<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:18
 */

namespace App\Controller\Roles;


use App\Entity\Roles\UseCase\CreateRole;
use App\Entity\Roles\UseCase\CreateRole\Responder;
use App\Form\Roles\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateRole $createRole
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/role/add", name="role_add", methods={"GET", "POST"})
     * @IsGranted("role_add")
     */
    public function index(Request $request, CreateRole $createRole)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateRole\Command(
                (string) $data['name'],
                $data['permissions']
            );
            $command->setResponder($this);

            $createRole->execute($command);

            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('roles');
        }

        return $this->render('roles/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function roleCreated(string $roleName)
    {
        $this->addFlash('success', 'Rola '.$roleName.' została stworzona');
    }

    public function roleNameExists()
    {
        $this->addFlash('error', 'Rola z wpisaną nazwą już istnieje');
    }
}