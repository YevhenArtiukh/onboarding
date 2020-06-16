<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:18
 */

namespace App\Adapter\Places;

use App\Entity\Places\Place;
use App\Entity\Places\Places as PlacesInterface;
use Doctrine\ORM\EntityManager;

class Places implements PlacesInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Place $place)
    {
        $this->entityManager->persist($place);
    }

    public function delete(Place $place)
    {
        $this->entityManager->remove($place);
    }

    /**
     * @param int $id
     * @return Place|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Place::class)->findOneBy([
            'id' => $id
        ]);
    }
}