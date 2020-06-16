<?php


namespace App\Adapter\Widgets;

use App\Entity\Roles\Role;
use App\Entity\Widgets\Widget;
use App\Entity\Widgets\Widgets as WidgetsInterface;
use Doctrine\ORM\EntityManager;

class Widgets implements WidgetsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function findAllByRole(Role $role)
    {
        return $this->entityManager->getRepository(Widget::class)->findByRoleAndDefaultPosition([
            'roleID' => $role->getId(),
            'defaultPosition'
        ]);
    }
}