<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 14:07
 */

namespace App\Form\Onboardings;

use App\Entity\Departments\Department;
use App\Entity\Users\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('u')
                        ->leftJoin(Department::class, 'd', Join::WITH, 'u.department = d.id')
                        ->where('d.division = :division')
                        ->andWhere('(u.onboarding != :onboarding OR u.onboarding IS NULL)')
                        ->setParameter('division', $options['division'])
                        ->setParameter('onboarding', $options['onboarding']);
                },
                'choice_label' => function (User $user) {
                    return $user->getFullName().' | '.$user->getLogin().' | '.$user->getDepartment()->getName();
                },
                'multiple' => true,
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Wybierz pracowników'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'division' => null,
            'onboarding' => null
        ]);
    }
}