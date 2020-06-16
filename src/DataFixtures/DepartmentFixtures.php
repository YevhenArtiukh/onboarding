<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 11:51
 */

namespace App\DataFixtures;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $divisions = $manager->getRepository(Division::class)->findAll();

        /** @var Division $division */
        foreach ($divisions as $division) {
            $department = new Department(
                'test obszar w dywizji '.$division->getName(),
                null,
                $division
            );
            $manager->persist($department);
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