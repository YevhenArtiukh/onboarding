<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:24
 */

namespace App\Controller\Places;


use App\Entity\Places\UseCase\CreatePlace;
use App\Entity\Places\UseCase\CreatePlace\Responder;
use App\Form\Places\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreatePlace $createPlace
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/place/add", name="place_add", methods={"GET", "POST"})
     * @IsGranted("place_add")
     */
    public function index(Request $request, CreatePlace $createPlace)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreatePlace\Command(
                (string) $data['name']
            );
            $command->setResponder($this);

            $createPlace->execute($command);

            return $this->redirectToRoute('places');
        }

        return $this->render('places/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function placeCreated()
    {
        $this->addFlash('success', 'Miejsce szkoleń zostało zapisane');
    }
}