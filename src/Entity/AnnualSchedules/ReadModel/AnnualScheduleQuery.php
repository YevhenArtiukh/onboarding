<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 13:02
 */

namespace App\Entity\AnnualSchedules\ReadModel;


interface AnnualScheduleQuery
{
    /**
     * @param int $year
     * @return mixed
     */
    public function findAll(int $year);

    /**
     * @return mixed
     */
    public function getListYear();
}