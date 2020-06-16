<?php


namespace App\Entity\TrainingDivisions\ReadModel;


use App\Entity\Divisions\Division;

interface TrainingDivisionsQuery
{
     public function getByDivision(Division $division);
}