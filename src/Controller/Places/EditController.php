<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:43
 */

namespace App\Controller\Places;


use App\Entity\Places\Place;
use App\Entity\Places\UseCase\EditPlace;
use App\Entity\Places\UseCase\EditPlace\Responder;
use App\Form\Places\EditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Place $place
     * @param EditPlace $editPlace
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/place/{place}/edit", name="place_edit", methods={"GET", "POST"})
     * @IsGranted("place_edit")
     */
    public function index(Request $request, Place $place, EditPlace $editPlace)
    {
        $form = $this->createForm(
            EditType::class,
            $place
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditPlace\Command(
                (int) $place->getId(),
                (string) $data->getName()
            );
            $command->setResponder($this);

            $editPlace->execute($command);

            if($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('places');
        }

        return $this->render('places/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function placeNotFound()
    {
        $this->addFlash('error', 'Miejsce szkoleń nie istnieje');
    }

    public function placeEdited()
    {
        $this->addFlash('success', 'Miejsce szkoleń zostało zmienione');
    }
}