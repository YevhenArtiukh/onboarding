<?php


namespace App\Entity\RelUsersWidgets;



use App\Entity\Users\User;

interface RelUsersWidgets
{
    public function add(RelUserWidget $relUserWidget);

    /**
     * @param User $user
     * @return array|null
     */
    public function findAllByUserAndCurrentRole(User $user );

    /**
     * @param string $userID
     * @param int $position
     * @return RelUserWidget|null
     */
    public function findOneByUserIDAndPosition(string $userID, int $position);


    /**
     * @param RelUserWidget $relUserWidget
     */
    public function remove(RelUserWidget $relUserWidget);
}
