<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:55
 */

namespace App\Entity\Permissions;


interface Permissions
{
    public function add(Permission $permission);
    public function delete(Permission $permission);

    /**
     * @param int $id
     * @return Permission|null
     */
    public function findOneById(int $id);

    /**
     * @param string $function
     * @return Permission|null
     */
    public function findOneByFunction(string $function);
}