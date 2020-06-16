<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 17:59
 */

namespace App\Adapter\Departments;

use App\Entity\Departments\Department;
use App\Entity\Departments\Departments as DepartmentsInterface;
use App\Entity\Divisions\Division;
use Doctrine\ORM\EntityManager;

class Departments implements DepartmentsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Department $department)
    {
        $this->entityManager->persist($department);
    }

    public function delete(Department $department)
    {
        $this->entityManager->remove($department);
    }

    /**
     * @param int $id
     * @return Department|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Department::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->entityManager->getRepository(Department::class)->findAll();
    }

    /**
     * @param Division $division
     * @return Department|null
     */
    public function findFirstLevelInDivision(Division $division)
    {
        return $this->entityManager->getRepository(Department::class)->findOneBy([
            'parent' => null,
            'division' => $division
        ]);
    }
}