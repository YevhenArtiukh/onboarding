<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 12:03
 */

namespace App\Entity\Onboardings\UseCase\ChangeStatusOnboarding;


use App\Adapter\Core\EmailFactory;
use App\Entity\Divisions\Division;
use App\Entity\Emails\Email;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Users\User;
use Psr\Log\LoggerInterface;

class GenerateEmailDivision
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

    public function notify(Email $email, User $user, Onboarding $onboarding, Division $division)
    {
        $template = $email->getMessage();

        $template = str_replace("$.USER.$",$user->getSurname().' '.$user->getName(),$template);
        $template = str_replace("$.MONTH.$", $onboarding->getMonth(),$template);
        $template = str_replace("$.DIVISION.$", $division->getName(),$template);

        $swiftMessage = $this->emailFactory->create(
            'Informacja o szkoleniach P&O',
            nl2br($template),
            [
                $user->getEmail()
            ]
        );

        try {
            $this->mailer->send($swiftMessage);
        } catch (\Throwable $e) {
            $this->logger->critical(
                sprintf('Error onboarding-division %s', $user->getId().'|'.$user->getName().'|'.$user->getSurname())
            );
            return;
        }
    }
}