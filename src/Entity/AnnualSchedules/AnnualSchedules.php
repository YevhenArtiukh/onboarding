<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-13
 * Time: 15:19
 */

namespace App\Entity\AnnualSchedules;


interface AnnualSchedules
{
    public function add(AnnualSchedule $annualSchedule);

    public function delete(AnnualSchedule $annualSchedule);

    /**
     * @param int $id
     * @return AnnualSchedule|null
     */
    public function findOneById(int $id);
}