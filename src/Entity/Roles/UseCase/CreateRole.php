<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:07
 */

namespace App\Entity\Roles\UseCase;


use App\Core\Transaction;
use App\Entity\Roles\Role;
use App\Entity\Roles\Roles;
use App\Entity\Roles\UseCase\CreateRole\Command;

class CreateRole
{
    private $roles;
    private $transaction;

    public function __construct(
        Roles $roles,
        Transaction $transaction
    )
    {
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingName = $this->roles->findOneByName($command->getName());

        if($existingName) {
            $command->getResponder()->roleNameExists();
            return;
        }

        $role = new Role(
            $command->getName(),
            $command->getPermissions()
        );

        $this->roles->add($role);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->commit();
            throw $e;
        }

        $command->getResponder()->roleCreated($role->getName());
    }
}