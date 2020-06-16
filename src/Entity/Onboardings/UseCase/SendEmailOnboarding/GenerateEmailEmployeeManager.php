<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 15:57
 */

namespace App\Entity\Onboardings\UseCase\SendEmailOnboarding;


use App\Adapter\Core\EmailFactory;
use App\Entity\Emails\Email;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Users\User;
use Psr\Log\LoggerInterface;

class GenerateEmailEmployeeManager
{
    private $mailer;
    private $logger;
    private $emailFactory;

    public function __construct(
        \Swift_Mailer $mailer,
        LoggerInterface $logger,
        EmailFactory $emailFactory
    )
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->emailFactory = $emailFactory;
    }

    public function notify(Email $email, User $user, Onboarding $onboarding, ?\DateTimeInterface $timeStart)
    {
        $template = $email->getMessage();

        $template = str_replace("$.USER.$",$user->getName(),$template);
        $template = str_replace("$.DATE.$",$onboarding->getDateStart()->format('d.m.Y'),$template);
        $template = str_replace("$.HOUR.$",$timeStart?$timeStart->format('H:i'):'',$template);
        $template = str_replace("$.PLACE.$",$onboarding->getHallStart(),$template);
        $template = str_replace("$.CONTACT_PERSON.$",$user->getDepartment()->getDivision()->getMessageEmail(),$template);

        $swiftMessage = $this->emailFactory->create(
            'Informacja o szkoleniach',
            nl2br($template),
            [
                $user->getEmail()
            ]
        );

        if($user->getDepartment()->getManager())
            $swiftMessage->setCc($user->getDepartment()->getManager()->getEmail());


        try {
            $this->mailer->send($swiftMessage);
        } catch (\Throwable $e) {
            $this->logger->critical(
                sprintf('Error onboarding-employee-manager %s', $user->getId().'|'.$user->getName().'|'.$user->getSurname())
            );
            return;
        }
    }
}