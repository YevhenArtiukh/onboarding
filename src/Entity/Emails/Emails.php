<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:06
 */

namespace App\Entity\Emails;


interface Emails
{
    public function add(Email $email);
    public function delete(Email $email);

    /**
     * @param int $id
     * @return Email|null
     */
    public function findOneById(int $id);

    /**
     * @param string $function
     * @return Email|null
     */
    public function findOneByFunction(string $function);
}