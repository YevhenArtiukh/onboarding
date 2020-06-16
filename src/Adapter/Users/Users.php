<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:15
 */

namespace App\Adapter\Users;

use App\Entity\Users\User;
use App\Entity\Users\Users as UsersInterface;
use Doctrine\ORM\EntityManager;

class Users implements UsersInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(User $user)
    {
        $this->entityManager->persist($user);
    }

    public function delete(User $user)
    {
        $this->entityManager->remove($user);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail(string $email)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $email
        ]);
    }

    /**
     * @param string $string
     * @return User|null
     */
    public function findLastForGenerateLogin(string $string)
    {
        return $this->entityManager->getRepository(User::class)->findLastForGenerateLogin(
            (string) $string
        );
    }

    /**
     * @param string $token
     * @return User|null
     */
    public function findOneByToken(string $token)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy([
            'token' => $token
        ]);
    }

    public function findByEmailExceptUser(string $email, User $user)
    {
       return $this->entityManager->getRepository(User::class)->findByEmailExceptUser([
           'email' => $email,
           'userID' => $user->getId()
       ]);
    }

    public function findAll()
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }
}