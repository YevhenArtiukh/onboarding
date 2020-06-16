<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:26
 */

namespace App\Controller\Onboardings;


use App\Entity\Onboardings\UseCase\CreateOnboarding;
use App\Entity\Onboardings\UseCase\CreateOnboarding\Responder;
use App\Form\Onboardings\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateOnboarding $createOnboarding
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/add", name="onboarding_add", methods={"GET", "POST"})
     * @IsGranted("onboarding_add")
     */
    public function index(Request $request, CreateOnboarding $createOnboarding)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateOnboarding\Command(
                (array) $data['days']
            );
            $command->setResponder($this);

            $id = $createOnboarding->execute($command);

            return $this->redirectToRoute('onboarding_show', ['onboarding' => $id]);
        }

        return $this->render('onboardings/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function onboardingCreated()
    {
        $this->addFlash('success', 'Onboarding został stworzony');
    }
}