<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 14:36
 */

namespace App\Controller\Onboardings;


use App\Adapter\Onboardings\Onboardings;
use App\Entity\Divisions\Division;
use App\Entity\OnboardingDivisions\OnboardingDivision;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\UseCase\AddUserOnboarding;
use App\Entity\Onboardings\UseCase\AddUserOnboarding\Responder as AddUserResponder;
use App\Entity\Onboardings\UseCase\AddUsersOnboarding;
use App\Entity\Onboardings\UseCase\AddUsersOnboarding\Responder as AddUsersResponder;
use App\Entity\Onboardings\UseCase\ChangeStatusOnboarding;
use App\Entity\Onboardings\UseCase\CopyOnboarding;
use App\Entity\Onboardings\UseCase\CopyOnboarding\Responder as CopyOnboardingResponder;
use App\Entity\Users\User;
use App\Form\Onboardings\AddUsersType;
use App\Form\Onboardings\AddUserType;
use App\Form\Onboardings\ChangeStatusType;
use App\Form\Onboardings\CopyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController implements AddUserResponder, AddUsersResponder, CopyOnboardingResponder
{
    /**
     * @param Onboarding $onboarding
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}", name="onboarding_show", methods={"GET", "POST"})
     */
    public function index(Request $request, Onboarding $onboarding, AddUserOnboarding $addUserOnboarding,
                          AddUsersOnboarding $addUsersOnboarding, ChangeStatusOnboarding $changeStatusOnboarding,
                          CopyOnboarding $copyOnboarding, Onboardings $onboardings)
    {
        $formUser = $this->createForm(
            AddUserType::class,
            [],
            [
                'division' => $this->getUser()->getDepartment()->getDivision()
            ]
        );
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $data = $formUser->getData();

            $command = new AddUserOnboarding\Command(
                $onboarding,
                $this->getUser()->getDepartment()->getDivision(),
                (string)$data['name'],
                (string)$data['surname'],
                (string)$data['email'],
                $data['identifier'],
                $data['department'],
                (string)$data['position'],
                (string)$data['formOfEmployment'],
                (string)$data['typeOfWorker'],
                $data['roles']
            );
            $command->setResponder($this);

            $addUserOnboarding->execute($command);

            if ($this->container->get('session')->getFlashBag()->has('success'))
                return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        $formUsers = $this->createForm(
            AddUsersType::class,
            [],
            [
                'division' => $this->getUser()->getDepartment()->getDivision(),
                'onboarding' => $onboarding
            ]
        );
        $formUsers->handleRequest($request);

        if ($formUsers->isSubmitted() && $formUsers->isValid()) {
            $data = $formUsers->getData();

            $command = new AddUsersOnboarding\Command(
                $data['users'],
                $onboarding
            );
            $command->setResponder($this);

            $addUsersOnboarding->execute($command);

            return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        $formChangeStatus = $this->createForm(
            ChangeStatusType::class
        );
        $formChangeStatus->handleRequest($request);

        if ($formChangeStatus->isSubmitted() && $formChangeStatus->isValid()) {
            $command = new ChangeStatusOnboarding\Command(
                $onboarding,
                $this->getUser()->getDepartment()->getDivision()
            );

            $changeStatusOnboarding->execute($command);

            return $this->redirectToRoute('onboardings');
        }

        $formCopy = $this->createForm(
            CopyType::class,
            [],
            [
                'disabled' => $this->checkDisabledCopyOnboarding(
                    $onboarding,
                    $this->getUser()->getDepartment()->getDivision(),
                    $lastOnboarding = $onboardings->getLastOnboardingForCopy($onboarding)
                )
            ]
        );
        $formCopy->handleRequest($request);

        if ($formCopy->isSubmitted() && $formCopy->isValid()) {

            $command = new CopyOnboarding\Command(
                $onboarding,
                $lastOnboarding,
                $this->getUser()->getDepartment()->getDivision()
            );
            $command->setResponder($this);

            $copyOnboarding->execute($command);

            return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
        }

        return $this->render('onboardings/show.html.twig', [
            'formUsers' => $formUsers->createView(),
            'formUser' => $formUser->createView(),
            'formChangeStatus' => $formChangeStatus->createView(),
            'formCopy' => $formCopy->createView()
        ]);
    }

    private function checkDisabledCopyOnboarding(Onboarding $onboarding, Division $division, ?Onboarding $lastOnboarding)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findByOnboardingDivision(
            $onboarding,
            $division
        );

        if (!$lastOnboarding || $users || (count($onboarding->getDays()) !== count($lastOnboarding->getDays())))
            return true;

        if ($onboarding->getStatus() === Onboarding\Status::STATUS_GENERAL)
            return false;

        /**
         * @var OnboardingDivision $div
         */
        foreach ($onboarding->getOnboardingDivisions() as $onboardingDivision) {
            if ($onboardingDivision->getDivision() === $division && !$onboardingDivision->getConfirmation())
                return false;
        }

        return true;
    }

    public function userCreated()
    {
        $this->addFlash('success', 'Użytkownik został stworzony');
    }

    public function emailExists()
    {
        $this->addFlash('error', 'Wpisany e-mail już istnieje');
    }

    public function lastOnboardingNotFound()
    {
        $this->addFlash('error', 'Poprzedni onboarding nie istnieje');
    }

    public function conflictTrainings()
    {
        $this->addFlash('error', 'Godzine są zajęte');
    }

    public function differentNumbersOfDays()
    {
        $this->addFlash('error', 'Nie można skopiować harmonogramu z poprzedniego onboardingu, ponieważ ilość dni części dywizyjnej różni się od ilości w poprzednim onboardingu');
    }

    public function onboardingCopied()
    {
        $this->addFlash('success', 'Onboarding został skopiowany');
    }
}