<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:15
 */

namespace App\Entity\Users;


interface Users
{
    public function add(User $user);
    public function delete(User $user);

    /**
     * @param int $id
     * @return User|null
     */
    public function findOneById(int $id);

    /**
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail(string $email);

    /**
     * @param string $string
     * @return User|null
     */
    public function findLastForGenerateLogin(string $string);

    /**
     * @param string $token
     * @return User|null
     */
    public function findOneByToken(string $token);

    /**
     * @param string $email
     * @param User $user
     * @return User|null
     */
    public function findByEmailExceptUser(string $email, User $user);

    public function findAll();
}