<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 18:02
 */

namespace App\Form\Departments;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use App\Entity\Users\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Nazwa obszaru'
            ])
            ->add('parent', EntityType::class, [
                'class' => Department::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('d')
                        ->where('d.division = :division')
                        ->orderBy('d.parent', 'ASC')
                        ->setParameter('division', $options['division']);
                },
                'choice_label' => function (Department $department) {
                    return $department->getName();
                },
                'placeholder' => '',
                'required' => false,
                'group_by' => 'parent.name',
                'attr' => [
                    'class' => 'select2 form-control custom-select',
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Obszar nadrzędny'
            ])
            ->add('manager', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('m')
                        ->leftJoin(Department::class, 'dep', Join::WITH, 'm.department = dep.id')
                        ->innerJoin('m.roles', 'r')
                        ->where('dep.division = :division')
                        ->andWhere('r.name = :roleName')
                        ->setParameter('division', $options['division'])
                        ->setParameter('roleName', 'Manager');
                },
                'choice_label' => function (User $user) {
                    return $user->getSurname().' '.$user->getName();
                },
                'placeholder' => '',
                'required' => false,
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ]
            ])
            ->add('businessPartner', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('m')
                        ->leftJoin(Department::class, 'dep', Join::WITH, 'm.department = dep.id')
                        ->innerJoin('m.roles', 'r')
                        ->where('dep.division = :division')
                        ->andWhere('(r.name = :role OR r.name = :roleDivision)')
                        ->setParameter('division', $options['division'])
                        ->setParameter('role', "P&O BP cross-dywizyjny")
                        ->setParameter('roleDivision', "P&O BP");
                },
                'choice_label' => function (User $user) {
                    return $user->getSurname().' '.$user->getName();
                },
                'placeholder' => '',
                'required' => false,
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'P&O BP'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'division' => null
        ]);
    }
}