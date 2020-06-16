<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:34
 */

namespace App\Form\Onboardings;


use App\Form\Onboardings\Onboarding\DayType;
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