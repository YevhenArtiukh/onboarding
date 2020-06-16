<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:25
 */

namespace App\Entity\Roles\UseCase;


use App\Core\Transaction;
use App\Entity\Roles\Roles;
use App\Entity\Roles\UseCase\EditRole\Command;

class EditRole
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

        $existingRole = $this->roles->findOneById(
            $command->getId()
        );

        if(!$existingRole) {
            $command->getResponder()->roleNotFound();
            return;
        }

        $existingName = $this->roles->findOneByName($command->getName());

        if($existingName && $existingName !== $existingRole) {
            $command->getResponder()->roleNameExists();
            return;
        }

        $existingRole->edit(
            $command->getName(),
            $command->getPermissions()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->roleEdited();
    }
}