<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-28
 * Time: 12:10
 */

namespace App\Form\Reports\ExportData;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSearchType extends AbstractType
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
                'label_attr' => [
                    'class' => 'number'
                ],
                'required' => false,
                'label' => 'Imię'
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label_attr' => [
                    'class' => 'number'
                ],
                'label' => 'Nazwisko'
            ])
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                switch ($options['user']->getCurrentRole()->getName()) {
                    case 'Manager':
                        return $entityRepository->createQueryBuilder('d')
                            ->where('d.manager = :user')
                            ->setParameter('user', $options['user']);
                        break;
                    case 'P&O BP':
                        return $entityRepository->createQueryBuilder('d')
                            ->leftJoin(Division::class, 'division', Join::WITH, 'd.division = division.id')
                            ->where('division = :division')
                            ->setParameter('division', $options['user']->getDepartment()->getDivision());
                        break;
                }
                    return $entityRepository->createQueryBuilder('d')
                        ->where('d.division = :division')
                        ->setParameter('division', $options['division']);
                },
                'choice_label' => function (Department $department) {
                    return $department->getName();
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'required' => false,
                'label' => 'Obszar'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => null
        ]);
    }
}