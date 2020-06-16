<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 14:32
 */

namespace App\Command\Emails;

use App\Entity\Users\User;
use App\Repository\Emails\EmailRepository;
use App\Repository\Users\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EvaluationSurveyEmployeeCommand extends Command
{
    protected static $defaultName = 'email:evaluation-survey';
    private $emailRepository;
    private $userRepository;
    private $urlGenerator;
    private $mailer;
    private $logger;

    public function __construct(
        EmailRepository $emailRepository,
        UserRepository $userRepository,
        UrlGeneratorInterface $urlGenerator,
        \Swift_Mailer $mailer,
        LoggerInterface $logger
    )
    {
        $this->emailRepository = $emailRepository;
        $this->userRepository = $userRepository;
        $this->urlGenerator = $urlGenerator;
        $this->mailer = $mailer;
        $this->logger = $logger;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailTemplate = $this->emailRepository->findOneBy(['function'=>'reminder-evaluation-survey']);
        if (!$emailTemplate)
            return 0;

        $template = $emailTemplate->getMessage();

        $message = new \Swift_Message('Prośba o wypełnienie ankiety');
        $message
            ->setFrom('admin@mystart.com.pl', 'myStart');

        /**
         * @var int $day
         */
        foreach ($emailTemplate->getDays() as $day) {
            $users = $this->userRepository->EvaluationSurveyEmployeeCommand($day);

            /**
             * @var User $user
             */
            foreach ($users as $user) {
                $template = str_replace("$.USER.$", $user->getName(), $template);
                $template = str_replace("$.LINK.$",'<a href="'.$this->urlGenerator->generate('dashboard').'" target="_blank">MyStart</a>',$template);

                $message
                    ->setTo($user->getEmail())
                    ->setBody(nl2br($template), 'text/html');

                $this->mailer->send($message);

                $this->logger->info('EvaluationSurveyEmployeeCommand sending on email ' . $user->getEmail());
            }
        }

        return 1;
    }
}