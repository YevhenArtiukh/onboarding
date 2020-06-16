<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 13:18
 */

namespace App\Form\Users;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use App\Entity\Roles\Role;
use App\Entity\Users\User\FormOfEmployment;
use App\Entity\Users\User\TypeOfWorker;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
                'label' => 'Imię'
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Nazwisko'
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'E-mail'
            ])
            ->add('department', EntityType::class, [
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
                'group_by' => 'parent.name',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Obszar'
            ])
            ->add('division', EntityType::class, [
                'class' => Division::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('d')
                        ->where('d = :division')
                        ->setParameter('division', $options['division']);
                },
                'choice_label' => function (Division $division) {
                    return $division->getName();
                },
                'attr' => [
                    'class' => 'form-control',
                    'disabled' => true
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Dywizja'
            ])
            ->add('date', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Data zatrudnienia'
            ])
            ->add('identifier', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Identyfikator 5-2-1',
                'required' => false
            ])
            ->add('position', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Stanowisko'
            ])
            ->add('formOfEmployment', ChoiceType::class, [
                'choices' => [
                    'internal' => FormOfEmployment::FORM_OF_EMPLOYMENT_INTERNAL,
                    'external' => FormOfEmployment::FORM_OF_EMPLOYMENT_EXTERNAL,
                    'Umowa zlecenie' => FormOfEmployment::FORM_OF_EMPLOYMENT_ORDER
                ],
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Forma zatrudnienia'
            ])
            ->add('typeOfWorker', ChoiceType::class, [
                'choices' => [
                    'biurowy' => TypeOfWorker::TYPE_OF_WORKER_OFFICE,
                    'terenowy' => TypeOfWorker::TYPE_OF_WORKER_FIELD
                ],
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Pracownik'
            ])
            ->add('roles', EntityType::class, [
                'class' => Role::class,
                'choice_label' => function (Role $role) {
                    return $role->getName();
                },
                'multiple' => true,
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Role'
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