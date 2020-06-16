<?php


namespace App\Adapter\RelUsersWidgets;
use App\Entity\RelUsersWidgets\RelUsersWidgets as RelUsersWidgetsInterface;
use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\Users\User;
use Doctrine\Common\Persistence\ObjectManager;

class RelUsersWidgets implements RelUsersWidgetsInterface
{

    private $manager;

    public function __construct(
        ObjectManager $manager
    )
    {
        $this->manager = $manager;
    }

    public function add(RelUserWidget $relUserWidget)
    {
       $this->manager->persist($relUserWidget);
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserAndCurrentRole(User $user)
    {
        return $this->manager->getRepository(RelUserWidget::class)->findByUserIDAndCurrentRoleID([
            'userID' => $user->getId(),
            'currentRoleID' => $user->getCurrentRole()->getId()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function findOneByUserIDAndPosition(string $userID, int $position)
    {
        return $this->manager->getRepository(RelUserWidget::class)->findOneBy([
            'userID' => (int)$userID,
            'position' => $position
        ]);
    }

    /**
     * @inheritDoc
     */
    public function remove(RelUserWidget $relUserWidget)
    {
        $this->manager->remove($relUserWidget);
    }


}