<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 14:47
 */

namespace App\Adapter\Core;


use App\Entity\Permissions\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class Voter implements VoterInterface
{

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token
     * @param mixed $subject The subject to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        $user = $token->getUser();

        if(!$user instanceof UserInterface) {
            return self::ACCESS_DENIED;
        }

        if(count($attributes) !== 1) {
            return self::ACCESS_DENIED;
        }

        $attribute = reset($attributes);

//        if(!in_array($attribute, self::OPTIONS)) {
//            return self::ACCESS_DENIED;
//        }

        $permissions = $user->getCurrentRole()->getPermissions();

        /**
         * @var Permission $permission
         */
        foreach ($permissions as $permission) {
            if($permission->getFunction() === $attribute)
                return self::ACCESS_GRANTED;
        }

        return self::ACCESS_DENIED;

//        return self::ACCESS_ABSTAIN;
    }
}