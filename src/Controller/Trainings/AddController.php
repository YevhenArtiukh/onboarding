<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:20
 */

namespace App\Controller\Trainings;


use App\Adapter\Trainings\UploadedImage;
use App\Entity\Trainings\UseCase\CreateTraining;
use App\Entity\Trainings\UseCase\CreateTraining\Responder;
use App\Form\Trainings\AddType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateTraining $createTraining
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/training/add", name="training_add", methods={"GET", "POST"})
     */
    public function index(Request $request, CreateTraining $createTraining)
    {
        $form = $this->createForm(
            AddType::class
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateTraining\Command(
                (string) $data['name'],
                (int) $data['time'],
                (string) $data['typeOfTraining'],
                (string) $data['kindOfTraining'],
                $data['description'],
                $data['trainerInfo'],
                $data['workerInfo'],
                 isset($data['additionalTraining'])?$data['additionalTraining']:false,
                isset($data['division'])?$data['division']:new ArrayCollection(),
                $data['image'] ? new UploadedImage(
                    $data['image'],
                    $this->getParameter('training_photo_dir')
                ):null
            );
            $command->setResponder($this);

            $createTraining->execute($command);

            return $this->redirectToRoute('trainings');
        }

        return $this->render('trainings/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}