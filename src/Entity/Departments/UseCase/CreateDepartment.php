<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 18:05
 */

namespace App\Entity\Departments\UseCase;


use App\Core\Transaction;
use App\Entity\Departments\Department;
use App\Entity\Departments\Departments;
use App\Entity\Departments\UseCase\CreateDepartment\Command;
use LogicException;

class CreateDepartment
{
    private $departments;
    private $transaction;

    public function __construct(
        Departments $departments,
        Transaction $transaction
    )
    {
        $this->departments = $departments;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        if(!$command->getParent() && $this->departments->findFirstLevelInDivision($command->getDivision())) {
            $command->getResponder()->departmentFirstLevelExists();
            return;
        }

        $department = new Department(
            $command->getName(),
            $command->getParent(),
            $command->getManager(),
            $command->getBusinessPartner(),
            $command->getDivision()
        );

        $this->departments->add($department);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->departmentCreated($department->getName());
    }
}