<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:47
 */

namespace App\Form\Questions;

use App\Entity\Exams\Exam\Type;
use App\Form\Questions\Question\ChoosesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                'label' => 'Pytanie'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => $options['answersType'],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'placeholder' => '',
                'label' => 'Typ odpowiedzi'
            ])
            ;

        $formModifier = function (
            FormInterface $form,
            string $type
        ){
            switch ($type) {
                case Type::ANSWER_TYPE_CHOOSE:
                    $form->add('answers', CollectionType::class, [
                        'entry_options' => [
                            'attr' => [
                                'class' => 'row'
                            ]
                        ],
                        'entry_type' => ChoosesType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'label' => false
                    ]);
                    break;
                case Type::ANSWER_TYPE_RATING:
                    break;
                case Type::ANSWER_TYPE_COMMENT:
                    break;
                case Type::ANSWER_TYPE_YES_NO:
                    break;
                case Type::ANSWER_TYPE_RATING_COMMENT:
                    break;
            }
        };

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier, $options) {
                $type = $event->getData()["type"];
                $formModifier(
                    $event->getForm(),
                    $type
                );
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'answersType' => null
        ]);
    }
}