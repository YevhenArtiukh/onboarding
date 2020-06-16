<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 9:58
 */

namespace App\Controller\Emails;


use App\Entity\Emails\UseCase\CreateEmail;
use App\Entity\Emails\UseCase\CreateEmail\Responder;
use App\Form\Emails\AddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/email/add", name="email_add", methods={"GET", "POST"})
     * @IsGranted("email_add")
     */
    public function index(Request $request, CreateEmail $createEmail)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateEmail\Command(
                (string) $data['name'],
                (string) $data['category'],
                (array) $data['days'],
                (string) $data['function'],
                $data['sentTo'],
                (string) $data['message'],
                (array) $data['variables']
            );
            $command->setResponder($this);

            $createEmail->execute($command);

            return $this->redirectToRoute('emails');
        }

        return $this->render('emails/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function emailCreated(string $name)
    {
        $this->addFlash('success', 'E-mail '.$name.' został stworzony');
    }

    public function emailExists()
    {
        $this->addFlash('error', 'E-mail już istnieje');
    }
}