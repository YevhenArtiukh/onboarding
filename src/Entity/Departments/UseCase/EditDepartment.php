<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-25
 * Time: 14:07
 */

namespace App\Entity\Departments\UseCase;


use App\Core\Transaction;
use App\Entity\Departments\Department;
use App\Entity\Departments\Departments;
use App\Entity\Departments\UseCase\EditDepartment\Command;

class EditDepartment
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

        $existingDepartment = $this->departments->findOneById($command->getId());

        if(!$existingDepartment) {
            $command->getResponder()->departmentNotFound();
            return;
        }

        $firstLevelDepartment = $this->departments->findFirstLevelInDivision($existingDepartment->getDivision());

        if(!$command->getParent() && $firstLevelDepartment && $firstLevelDepartment !== $existingDepartment) {
            $command->getResponder()->departmentFirstLevelExists();
            return;
        }

        if($command->getParent() && in_array($command->getParent()->getId(), $this->buildTree(
                $this->departments->findAll(),
                $command->getId()
        ))) {
            $command->getResponder()->errorBuildTree();
            return;
        }

        $existingDepartment->edit(
            $command->getName(),
            $command->getParent(),
            $command->getManager(),
            $command->getBusinessPartner()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->departmentEdited();
    }

    private function buildTree(array $data, $parentId = null)
    {
        $branch = array();

        /**
         * @var Department $element
         */
        foreach ($data as $key=>$element)
        {
            unset($data[$key]);
            if($element->getParent() && $element->getParent()->getId() == $parentId) {
                $this->buildTree($data, $element->getId());
                $branch[] = $element->getId();
            }
        }

        return $branch;
    }
}