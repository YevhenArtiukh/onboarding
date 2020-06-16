<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 13:58
 */

namespace App\Entity\Onboardings\UseCase\SendEmailOnboarding;


use App\Adapter\Core\EmailFactory;
use App\Entity\Emails\Email;
use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GenerateEmailCoach
{
    private $mailer;
    private $logger;
    private $emailFactory;
    private $urlGenerator;

    public function __construct(
        \Swift_Mailer $mailer,
        LoggerInterface $logger,
        EmailFactory $emailFactory,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->emailFactory = $emailFactory;
        $this->urlGenerator = $urlGenerator;
    }

    public function notify(Email $email, User $user, Onboarding $onboarding, OnboardingTraining $onboardingTraining)
    {
        $template = $email->getMessage();

        $template = str_replace("$.USER.$",$user->getName(),$template);
        $template = str_replace("$.DATE.$",$onboarding->getDateStart()->format('d.m.Y'),$template);
        $template = str_replace("$.TRAINING.$",$onboardingTraining->getTraining()->getName(),$template);

        if ($onboardingTraining->getTime())
            $time = ' '.$onboardingTraining->getTime()->format('H:i');
        $template = str_replace("$.TRAINING_DATE.$",(date_modify($onboarding->getDateStart(), '+'.($onboardingTraining->getDay()-1).' day')->format('d.m.Y')).($time??null),$template);
        $template = str_replace("$.LINK.$",'<a href="'.$this->urlGenerator->generate('dashboard',[],0).'" target="_blank">'.$this->urlGenerator->generate('dashboard',[],0).'</a>',$template);

        $swiftMessage = $this->emailFactory->create(
            'Informacja o szkoleniach dla trenerów',
            nl2br($template),
            [
                $user->getEmail()
            ]
        );

        try {
            $this->mailer->send($swiftMessage);
        } catch (\Throwable $e) {
            $this->logger->critical(
                sprintf('Error onboarding-coach %s', $user->getId().'|'.$user->getName().'|'.$user->getSurname())
            );
            return;
        }
    }
}