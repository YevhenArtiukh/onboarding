<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 10:52
 */

namespace App\Entity\Users\UseCase\PasswordReset;

use App\Adapter\Core\EmailFactory;
use App\Entity\Emails\Email;
use App\Entity\Users\User;
use LogicException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GenerateEmail
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

    public function notify(Email $email, User $user, string $token)
    {
        $template = $email->getMessage();

        $template = str_replace("$.USER.$",$user->getName(),$template);
        $template = str_replace("$.LINK.$",'<a href="'.$this->urlGenerator->generate('password_reset_change', ['token'=>$token], 3).'" target="_blank">Zresetuj hasło</a>',$template);

        $swiftMessage = $this->emailFactory->create(
            'Resetowanie hasła myStart',
            nl2br($template),
            [
                $user->getEmail()
            ]
        );

        try {
            $this->mailer->send($swiftMessage);
        } catch (\Throwable $e) {
            $this->logger->critical(
                sprintf('Error password-reset %s', $user->getId().'|'.$user->getName().'|'.$user->getSurname())
            );
            return;
        }
    }
}