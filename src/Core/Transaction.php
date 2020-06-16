<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:22
 */

namespace App\Core;


interface Transaction
{
    public function begin();
    public function commit();
    public function rollback();
}