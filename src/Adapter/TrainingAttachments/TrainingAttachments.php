<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 15:46
 */

namespace App\Adapter\TrainingAttachments;

use App\Entity\TrainingAttachments\TrainingAttachment;
use App\Entity\TrainingAttachments\TrainingAttachments as TrainingAttachmentsInterface;
use Doctrine\ORM\EntityManager;

class TrainingAttachments implements TrainingAttachmentsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(TrainingAttachment $trainingAttachment)
    {
        $this->entityManager->persist($trainingAttachment);
    }

    public function delete(TrainingAttachment $trainingAttachment)
    {
        $this->entityManager->remove($trainingAttachment);
    }

    /**
     * @param int $id
     * @return TrainingAttachment|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(TrainingAttachment::class)->findOneBy([
            'id' => $id
        ]);
    }
}