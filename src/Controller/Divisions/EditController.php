<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 17:08
 */

namespace App\Controller\Divisions;


use App\Entity\Divisions\Division;
use App\Entity\Divisions\UseCase\EditDivision;
use App\Entity\Divisions\UseCase\EditDivision\Responder;
use App\Form\Divisions\EditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Division $division
     * @param EditDivision $editDivision
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/division/{division}/edit", name="division_edit", methods={"GET", "POST"})
     * @IsGranted("division_edit")
     */
    public function index(Request $request, Division $division, EditDivision $editDivision)
    {
        $form = $this->createForm(
            EditType::class,
            $division
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditDivision\Command(
                (int)$data->getId(),
                (string)$data->getName(),
                $data->getMessageEmail()
            );
            $command->setResponder($this);

            $editDivision->execute($command);

            return $this->redirectToRoute('divisions');
        }

        return $this->render('divisions/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}