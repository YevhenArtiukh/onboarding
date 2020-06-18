<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 11:48
 */

namespace App\DataFixtures;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use App\Entity\Roles\Role;
use App\Entity\Users\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $divisions = $manager->getRepository(Division::class)->findAll();
        $roles = $manager->getRepository(Role::class)->findAll();

        /** @var Division $division */
        foreach ($divisions as $key => $division) {
            $department = $manager->getRepository(Department::class)->findOneBy(['name'=>'test obszar w dywizji '.$division->getName()]);
            $user = new User(
                'user '.$division->getName(),
                'nazwisko',
                $division->getName().'test@mail.test',
                $department,
                'testowy identyfikator '.$key,
                'testowe stanowisko w '.$division->getName(),
                User\FormOfEmployment::FORM_OF_EMPLOYMENT_EXTERNAL,
                User\TypeOfWorker::TYPE_OF_WORKER_OFFICE,
                new ArrayCollection($roles),
                $division->getName(),
                password_hash($division->getName(), PASSWORD_BCRYPT),
                null,
                new ArrayCollection()
            );
            $manager->persist($user);
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
        return 3;
    }
}