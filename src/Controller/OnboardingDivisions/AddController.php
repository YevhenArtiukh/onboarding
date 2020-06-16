<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:30
 */

namespace App\Controller\OnboardingDivisions;


use App\Entity\OnboardingDivisions\UseCase\CreateOnboardingDivision;
use App\Entity\OnboardingDivisions\UseCase\CreateOnboardingDivision\Responder;
use App\Entity\Onboardings\Onboarding;
use App\Form\OnboardingDivisions\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Onboarding $onboarding
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/division/add", name="onboarding_division_add", methods={"GET", "POST"})
     * @IsGranted("onboarding_training_add_division")
     */
    public function index(Request $request, Onboarding $onboarding, CreateOnboardingDivision $createOnboardingDivision)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateOnboardingDivision\Command(
                $onboarding,
                $this->getUser()->getDepartment()->getDivision(),
                (array)$data['days']
            );
            $command->setResponder($this);

            $createOnboardingDivision->execute($command);

            return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        return $this->render('onboarding_divisions/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function onboardingDivisionExists()
    {
        $this->addFlash('error', 'Termin dla dywizji już został stworzony');
    }
}