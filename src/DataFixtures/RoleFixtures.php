<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 11:37
 */

namespace App\DataFixtures;


use App\Entity\Permissions\Permission;
use App\Entity\Roles\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $roles = [
            'Administrator',
            'P&O BP cross-dywizyjny',
            'P&O BP',
            'Manager',
            'Trener',
            'Pracownik'
        ];

        foreach ($roles as $name) {
            $role = new Role(
                $name,
                new ArrayCollection($manager->getRepository(Permission::class)->findAll())
            );
            $manager->persist($role);
        }
        $manager->flush();

    }

    /**
     * Get the order of this fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}