<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 12:07
 */

namespace App\Controller\Emails;


use App\Adapter\Emails\ReadModel\EmailQuery;
use App\Entity\Emails\Email;
use App\Entity\Emails\UseCase\EditEmail;
use App\Entity\Emails\UseCase\EditEmail\Responder;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Users\User;
use App\Form\Emails\EditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController implements Responder
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/emails", name="emails", methods={"GET", "POST"})
     * @IsGranted("emails")
     */
    public function index(Request $request, EditEmail $editEmail)
    {
        $emails = $this->getDoctrine()->getRepository(Email::class)->findAll();

        /**
         * @var Email $email
         */
        foreach ($emails as $email) {
            $form[$email->getId()] = $this->get('form.factory')->createNamed(
                'form_'.$email->getId(),
                EditType::class,
                $email
            );

            $form[$email->getId()]->handleRequest($request);

            if($form[$email->getId()]->isSubmitted() && $form[$email->getId()]->isValid()) {
                $data = $form[$email->getId()]->getData();

                $command = new EditEmail\Command(
                    (int) $email->getId(),
                    (string) $data->getName(),
                    (array) $data->getDays(),
                    $data->getSentTo(),
                    (string) $data->getMessage()
                );
                $command->setResponder($this);

                $editEmail->execute($command);

                return $this->redirectToRoute('emails');
            }
            $forms[$email->getId()] = $form[$email->getId()]->createView();
        }

        return $this->render('emails/list.html.twig', [
            'forms' => $forms??null
        ]);
    }

    public function emailNotFound()
    {
        $this->addFlash('error', 'Podany e-mail nie istnieje');
    }

    public function emailEdited()
    {
        $this->addFlash('success', 'E-mail został zmieniony');
    }
}