<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-15
 * Time: 11:37
 */

namespace App\DataFixtures;


use App\Entity\Permissions\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PermissionFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $permissions = [
            'lista miejsc szkoleń' => 'places',
            'dodanie miejsc szkoleń' => 'place_add',
            'zmiana miejsc szkoleń' => 'place_edit',
            'dodanie onboardingu' => 'onboarding_add',
            'usuwanie onboardingu' => 'onboarding_delete',
            'dodanie szkoleń do części wspólnej' => 'onboarding_training_add_general',
            'dodanie szkoleń do części dywizyjnej' => 'onboarding_training_add_division',
            'lista szkoleń cross-dywizyjnych' => 'training_general',
            'lista szkoleń dywizyjnych' => 'training_division',
            'dodanie osób do onboardingu' => 'onboarding_add_users',
            'dodawać onb w ramach harmonogramu rocznego, edytować i usuwać' => 'annual_schedules_action',
            'podgląd harmonogramu rocznego' => 'annual_schedules_list',
            'plan szkoleń pracownik' => 'training_schedule_employee',
            'plan szkoleń ogólny' => 'training_schedule_general',
            'zakładka trener' => 'coach_onboarding_trainings',
            'raport dotyczący ankiet ewaluacyjnych' => 'evaluation_survey',
            'raport z liczbą uczestników w onboardingach' => 'number_of_participants',
            'Zaliczanie obecności za trenera' => 'coaching',
            'Strona główna' => 'dashboard_page',
            'lista uprawnień' => 'permissions',
            'dodanie uprawnienia' => 'permission_add',
            'zmiana uprawnienia' => 'permission_edit',
            'lista ról' => 'roles',
            'dodanie roli' => 'role_add',
            'zmiana roli' => 'role_edit',
            'modul powiadomień' => 'emails',
            'dodanie nowych powiadomień' => 'email_add',
            'lista użytkowników' => 'users',
            'lista dywizji' => 'divisions',
            'dodanie dywizji' => 'division_add',
            'zmiana dywizji' => 'division_edit',
            'lista obszarów' => 'departments',
            'dodanie obszaru' => 'department_add',
            'zmiana obszarów' => 'department_edit',
            'lista onboardingów' => 'onboardings',
            'możliwość migrować osób między dywizjami' => 'migration'
        ];

        foreach ($permissions as $name => $function) {
            $permission = new Permission(
                $name,
                $function
            );
            $manager->persist($permission);
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
        return 1;
    }
}