<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 16:43
 */

namespace App\Controller\Divisions;


use App\Entity\Divisions\UseCase\CreateDivision;
use App\Entity\Divisions\UseCase\CreateDivision\Responder;
use App\Form\Divisions\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateDivision $createDivision
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/division/add", name="division_add", methods={"GET", "POST"})
     * @IsGranted("division_add")
     */
    public function index(Request $request, CreateDivision $createDivision)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateDivision\Command(
                (string)$data['name'],
                $data['messageEmail']
            );
            $command->setResponder($this);

            $createDivision->execute($command);

            return $this->redirectToRoute('divisions');
        }

        return $this->render('divisions/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}