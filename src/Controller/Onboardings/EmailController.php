<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 13:39
 */

namespace App\Controller\Onboardings;


use App\Entity\Onboardings\Onboarding;
use App\Entity\Onboardings\UseCase\SendEmailOnboarding;
use App\Entity\Onboardings\UseCase\SendEmailOnboarding\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController implements Responder
{
    /**
     * @throws \Throwable
     * @Route("/onboarding/{onboarding}/email", name="onboarding_email", methods={"POST"})
     */
    public function index(Onboarding $onboarding, SendEmailOnboarding $sendEmailOnboarding)
    {
        $command = new SendEmailOnboarding\Command(
            $onboarding
        );
        $command->setResponder($this);

        $sendEmailOnboarding->execute($command);

        return $this->redirectToRoute('onboarding_show', ['onboarding' => $onboarding->getId()]);
    }

    public function emailSent()
    {
        $this->addFlash('success','E-maile z powiadomieniami zostały wysłane');
    }
}