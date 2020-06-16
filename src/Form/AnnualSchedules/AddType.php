<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-13
 * Time: 15:28
 */

namespace App\Form\AnnualSchedules;


use App\Form\AnnualSchedules\AnnualSchedule\DayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Data od:'
            ])
            ->add('dateEnd', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Data do:'
            ])
            ->add('days', CollectionType::class, [
                'entry_options' => [
                    'attr' => [
                        'class' => 'row'
                    ]
                ],
                'entry_type' => DayType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'label' => false
            ])
            ;
    }
}