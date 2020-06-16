<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:55
 */

namespace App\Adapter\Permissions;

use App\Entity\Permissions\Permission;
use App\Entity\Permissions\Permissions as PermissionsInterface;
use Doctrine\ORM\EntityManager;

class Permissions implements PermissionsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Permission $permission)
    {
        $this->entityManager->persist($permission);
    }

    public function delete(Permission $permission)
    {
        $this->entityManager->remove($permission);
    }

    /**
     * @param int $id
     * @return Permission|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Permission::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param string $function
     * @return Permission|null
     */
    public function findOneByFunction(string $function)
    {
        return $this->entityManager->getRepository(Permission::class)->findOneBy([
            'function' => $function
        ]);
    }
}