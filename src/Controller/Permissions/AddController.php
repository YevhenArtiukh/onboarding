<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:59
 */

namespace App\Controller\Permissions;


use App\Entity\Permissions\UseCase\CreatePermission;
use App\Entity\Permissions\UseCase\CreatePermission\Responder;
use App\Form\Permissions\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreatePermission $createPermission
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/permission/add", name="permission_add", methods={"GET", "POST"})
     * @IsGranted("permission_add")
     */
    public function index(Request $request, CreatePermission $createPermission)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreatePermission\Command(
                (string) $data['name'],
                (string) $data['function']
            );
            $command->setResponder($this);

            $createPermission->execute($command);


            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('permissions');
        }

        return $this->render('permissions/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function permissionCreated(string $namePermission)
    {
        $this->addFlash('success', 'Uprawnienie '.$namePermission.' zostało stworzone');
    }

    public function functionExists()
    {
        $this->addFlash('error', 'Uprawnienie z wpisaną funkcją już istnieje');
    }
}