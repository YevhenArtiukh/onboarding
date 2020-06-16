<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:21
 */

namespace App\Entity\Permissions\UseCase;


use App\Core\Transaction;
use App\Entity\Permissions\Permissions;
use App\Entity\Permissions\UseCase\EditPermission\Command;

class EditPermission
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

        $existingPermission = $this->permissions->findOneById(
            $command->getId()
        );

        if(!$existingPermission) {
            $command->getResponder()->permissionNotFound();
            return;
        }

        $existingFunction = $this->permissions->findOneByFunction($command->getFunction());
        if($existingFunction !== $existingPermission) {
            $command->getResponder()->functionExists();
            return;
        }

        $existingPermission->edit(
            $command->getName(),
            $command->getFunction()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->permissionEdited();
    }
}