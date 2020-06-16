<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-04
 * Time: 13:49
 */

namespace App\Controller\PresenceParticipants;


use App\Adapter\PresenceParticipants\ReadModel\PresenceParticipantQuery;
use App\Entity\Trainings\Training;
use App\Entity\Users\User;
use App\Form\PresenceParticipants\CoachingSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CoachingSearchController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/coaching", name="coaching_search", methods={"GET", "POST"})
     * @IsGranted("coaching")
     */
    public function index(Request $request, PresenceParticipantQuery $presenceParticipantQuery)
    {
        $form = $this->createForm(
            CoachingSearchType::class,
            [
                'training' => $request->get('training') ? $this->getDoctrine()->getRepository(Training::class)->findOneBy(['id' => $request->get('training')]) : null,
                'coach' => $request->get('coach') ? $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $request->get('coach')]) : null,
                'date' => $request->get('date')
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('coaching_search', [
                'training' => $data['training']->getId(),
                'coach' => $data['coach']->getId(),
                'date' => $data['date']
            ]);
        }

        if ($request->get('training') && $request->get('coach')) {
            $onboardingTrainings = $presenceParticipantQuery->coachingSearch(
                $request->get('training'),
                $request->get('coach'),
                $request->get('date')
            );
        }

        return $this->render('presence_participants/coaching_search.html.twig', [
            'form' => $form->createView(),
            'onboardingTrainings' => $onboardingTrainings ?? null
        ]);
    }
}