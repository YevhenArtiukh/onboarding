<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 14:31
 */

namespace App\Command\Emails;

use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;
use App\Repository\Emails\EmailRepository;
use App\Repository\Onboardings\OnboardingRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OnboardingCoachCommand extends Command
{
    protected static $defaultName = 'email:onboarding-coach';
    private $emailRepository;
    private $onboardingRepository;
    private $mailer;
    private $logger;

    public function __construct(
        EmailRepository $emailRepository,
        OnboardingRepository $onboardingRepository,
        \Swift_Mailer $mailer,
        LoggerInterface $logger
    )
    {
        $this->emailRepository = $emailRepository;
        $this->onboardingRepository = $onboardingRepository;
        $this->mailer = $mailer;
        $this->logger = $logger;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailTemplate = $this->emailRepository->findOneBy(['function' => 'reminder-onboarding-coach']);

        if (!$emailTemplate)
            return;

        $template = $emailTemplate->getMessage();

        $message = new \Swift_Message('Przypomnienie o onboardingu');
        $message
            ->setFrom('admin@mystart.com.pl', 'myStart');

        /**
         * @var int $day
         */
        foreach ($emailTemplate->getDays() as $day) {
            $onboardings = $this->onboardingRepository->onboardingCoachCommand($day);

            /**
             * @var Onboarding $onboarding
             */
            foreach ($onboardings as $onboarding) {

                /**
                 * @var OnboardingTraining $onboardingTraining
                 */
                foreach ($onboarding->getOnboardingTrainings()->toArray() as $onboardingTraining) {

                    /**
                     * @var User $coach
                     */
                    foreach ($onboardingTraining->getCoaches()->toArray() as $coach) {

                        $template = str_replace("$.USER.$", $coach->getName(), $template);
                        $template = str_replace("$.DATE.$", $onboarding->getDateStart()->format('d.m.Y'), $template);
                        $template = str_replace("$.TRAINING.$", $onboardingTraining->getTraining()->getName(), $template);
                        $template = str_replace("$.TRAINING_DATE.$",date_modify($onboarding->getDateStart(), '+'.($onboardingTraining->getDay()-1).' day')->format('d.m.Y'),$template);
                        $template = str_replace("$.TRAINING_HOUR.$",($onboardingTraining->getTime()?$onboardingTraining->getTime()->format('H:i'):''),$template);
                        $template = str_replace("$.CONTACT_PERSON.$",$coach->getDepartment()->getDivision()->getMessageEmail(),$template);

                        $message
                            ->setTo($coach->getEmail())
                            ->setBody(nl2br($template), 'text/html');

                        $this->mailer->send($message);

                        $this->logger->info('OnboardingCoachCommand sending on email ' . $coach->getEmail());
                    }
                }
            }
        }

        return 1;
    }
}