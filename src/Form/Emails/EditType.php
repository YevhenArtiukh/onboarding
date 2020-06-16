<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 9:59
 */

namespace App\Form\Emails;


use App\Entity\Emails\Email\Category as EmailCategory;
use App\Entity\Emails\ReadModel\Email\Category;
use App\Entity\Roles\Role;
use App\Form\Emails\Email\VariablesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
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
                'label' => 'Tytuł'
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    (new Category(EmailCategory::ADMINISTRATIVE))->__toString() => EmailCategory::ADMINISTRATIVE,
                    (new Category(EmailCategory::ONBOARDING))->__toString() => EmailCategory::ONBOARDING,
                    (new Category(EmailCategory::DEADLINES_TRAINING))->__toString() => EmailCategory::DEADLINES_TRAINING
                ]
                ,
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'd-none'
                ],
                'label' => 'Kategoria'
            ])
            ->add('days', ChoiceType::class, [
                'choices' => range(1,100),
                'choice_label' => function ($choice) {
                    return $choice;
                },
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'multiple' => true,
                'required' => false,
                'label' => 'Termin'
            ])
            ->add('sentTo', EntityType::class, [
                'class' => Role::class,
                'choice_label' => function (Role $roles) {
                    return $roles->getName();
                },
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'multiple' => true,
                'label' => 'Wysyłane do'
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 10
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Treść'
            ])
            ->add('variables', CollectionType::class, [
                'entry_options' => [
                    'attr' => [
                        'class' => 'row'
                    ]
                ],
                'entry_type' => VariablesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'pt-3'
            ]
        ]);
    }
}