<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:01
 */

namespace App\Entity\Permissions\UseCase;


use App\Core\Transaction;
use App\Entity\Permissions\Permission;
use App\Entity\Permissions\Permissions;
use App\Entity\Permissions\UseCase\CreatePermission\Command;

class CreatePermission
{
    private $permissions;
    private $transaction;

    public function __construct(
        Permissions $permissions,
        Transaction $transaction
    )
    {
        $this->permissions = $permissions;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingFunction = $this->permissions->findOneByFunction($command->getFunction());

        if($existingFunction) {
            $command->getResponder()->functionExists();
            return;
        }

        $permission = new Permission(
            $command->getName(),
            $command->getFunction()
        );

        $this->permissions->add($permission);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->permissionCreated($permission->getName());
    }
}