<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:57
 */

namespace App\Adapter\Roles;

use App\Entity\Roles\Role;
use App\Entity\Roles\Roles as RolesInterface;
use Doctrine\ORM\EntityManager;

class Roles implements RolesInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Role $role)
    {
        $this->entityManager->persist($role);
    }

    public function delete(Role $role)
    {
        $this->entityManager->remove($role);
    }

    /**
     * @param int $id
     * @return Role|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Role::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param string $name
     * @return Role|null
     */
    public function findOneByName(string $name)
    {
        return $this->entityManager->getRepository(Role::class)->findOneBy([
            'name' => $name
        ]);
    }
}