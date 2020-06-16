<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 15:44
 */

namespace App\Entity\TrainingAttachments;


interface TrainingAttachments
{
    public function add(TrainingAttachment $trainingAttachment);
    public function delete(TrainingAttachment $trainingAttachment);

    /**
     * @param int $id
     * @return TrainingAttachment|null
     */
    public function findOneById(int $id);
}