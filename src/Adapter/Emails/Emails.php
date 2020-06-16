<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:07
 */

namespace App\Adapter\Emails;

use App\Entity\Emails\Email;
use App\Entity\Emails\Emails as EmailsInterface;
use Doctrine\ORM\EntityManager;

class Emails implements EmailsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Email $email)
    {
        $this->entityManager->persist($email);
    }

    public function delete(Email $email)
    {
        $this->entityManager->remove($email);
    }

    /**
     * @param int $id
     * @return Email|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Email::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param string $function
     * @return Email|null
     */
    public function findOneByFunction(string $function)
    {
        return $this->entityManager->getRepository(Email::class)->findOneBy([
            'function' => $function
        ]);
    }
}