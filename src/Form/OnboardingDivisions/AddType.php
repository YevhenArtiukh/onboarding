<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:33
 */

namespace App\Form\OnboardingDivisions;


use App\Form\OnboardingDivisions\OnboardingDivision\DayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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