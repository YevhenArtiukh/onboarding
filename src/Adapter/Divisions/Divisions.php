<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 16:39
 */

namespace App\Adapter\Divisions;


use App\Entity\Divisions\Division;
use Doctrine\ORM\EntityManager;
use App\Entity\Divisions\Divisions as DivisionsInterface;

class Divisions implements DivisionsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Division $division)
    {
        $this->entityManager->persist($division);
    }

    public function delete(Division $division)
    {
        $this->entityManager->remove($division);
    }

    /**
     * @param int $id
     * @return Division|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Division::class)->findOneBy([
            'id' => $id
        ]);
    }
}