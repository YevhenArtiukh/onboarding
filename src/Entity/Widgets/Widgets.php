<?php


namespace App\Entity\Widgets;


use App\Entity\Roles\Role;

interface Widgets
{
    /**
     * @param Role $role
     * @return Widget[]
     */
    public function findAllByRole(Role $role);

}