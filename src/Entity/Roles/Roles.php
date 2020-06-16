<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:57
 */

namespace App\Entity\Roles;


interface Roles
{
    public function add(Role $role);
    public function delete(Role $role);

    /**
     * @param int $id
     * @return Role|null
     */
    public function findOneById(int $id);

    /**
     * @param string $name
     * @return Role|null
     */
    public function findOneByName(string $name);
}