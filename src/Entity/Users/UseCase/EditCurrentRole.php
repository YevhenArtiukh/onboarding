<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 12:39
 */

namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Roles\Roles;
use App\Entity\Users\UseCase\EditCurrentRole\Command;

class EditCurrentRole
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

        $existingRole = $this->roles->findOneByName($command->getName());

        if(!$existingRole) {
            return;
        }

        $command->getUser()->setCurrentRole($existingRole);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        return $existingRole;
    }
}