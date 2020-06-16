<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 12:33
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\EditCurrentRole;
use App\Entity\Users\UseCase\EditCurrentRole\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EditCurrentRoleController extends AbstractController implements Responder
{
    /**
     * @param string $role
     * @param EditCurrentRole $editCurrentRole
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Throwable
     * @Route("/change/current-role/{role}", name="change_current_role", methods={"GET"})
     */
    public function index(string $role, EditCurrentRole $editCurrentRole)
    {
        $command = new EditCurrentRole\Command(
            $role,
            $this->getUser()
        );
        $command->setResponder($this);

        $role = $editCurrentRole->execute($command);

        if($role->getName() == "Pracownik" || $role->getName() == "Manager")
            return $this->redirectToRoute('training_schedule_general');
        return $this->redirectToRoute('dashboard');
    }
}