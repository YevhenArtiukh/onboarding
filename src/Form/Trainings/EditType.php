<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:22
 */

namespace App\Form\Trainings;


use App\Entity\Divisions\Division;
use App\Entity\Trainings\Training\KindOfTraining;
use App\Entity\Trainings\Training\TypeOfTraining;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                'label' => 'Nazwa szkolenia',
                'required' => true
            ])
            ->add('time', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'html5' => true,
                'label' => 'Czas trwania(min)',
                'required' => true
            ])
            ->add('kindOfTraining', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'choices' => [
                    'Szkolenie wspólne' => KindOfTraining::KIND_OF_TRAINING_GENERAL,
                    'Szkolenie dywizyjne' => KindOfTraining::KIND_OF_TRAINING_DIVISIONS
                ],
                'placeholder' => '',
                'label' => 'Rodzaj szkolenia',
                'required' => true
            ])
            ->add('typeOfTraining', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'choices' => [
                    'Szkolenie stacjonarne ' => TypeOfTraining::TYPE_OF_TRAINING_STATIONARY,
                    'Szkolenie online' => TypeOfTraining::TYPE_OF_TRAINING_ONLINE,
                    'Przerwa' => TypeOfTraining::TYPE_OF_TRAINING_PAUSE,
                ],
                'placeholder' => '',
                'label' => 'Typ szkolenia',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 10
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'required' => false,
                'label' => 'Informacja'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'required' => false,
                'label' => 'Informacja o szkoleniu'
            ])
            ->add('trainerInfo', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'required' => false,
                'label' => 'Komunikat dla trenera'
            ])
            ->add('workerInfo', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'required' => false,
                'label' => 'Komunikat dla pracownika'
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'attr' => [
                    'name' => 'file',
                    'style' => 'display:none;'
                ],
                'label' => false
            ]);

        if ($options['kindOfTraining'] == KindOfTraining::KIND_OF_TRAINING_DIVISIONS) {

            $builder
                ->add('division', EntityType::class, [
                    'class' => Division::class,
                    'choice_label' => function (Division $division) {
                        return $division->getName();
                    },
                    'attr' => [
                        'class' => 'select2 form-control'
                    ],
                    'multiple' => true,
                    'label' => 'Wybór dywizji',
                    'required' => true
                ])
                ->add('additionalTraining', CheckboxType::class, [
                    'attr' => [
                        'class' => 'material-inputs filled-in chk-col-light-blue'
                    ],
                    'required' => false,
                    'label' => 'Szkolenie dodatkowe'
                ]);
        }
    

        $formModifier = function (
            FormInterface $form,
            string $kindOfTraining
        ) {
            if ($kindOfTraining == KindOfTraining::KIND_OF_TRAINING_DIVISIONS) {
                $form->add('division', EntityType::class, [
                    'class' => Division::class,
                    'choice_label' => function (Division $division) {
                        return $division->getName();
                    },
                    'attr' => [
                        'class' => 'select2 form-control'
                    ],
                    'multiple' => true,
                    'label' => 'Wybór dywizji',
                    'required' => true
                ])
                    ->add('additionalTraining', CheckboxType::class, [
                        'attr' => [
                            'class' => 'material-inputs filled-in chk-col-light-blue'
                        ],
                        'required' => false,
                        'label' => 'Szkolenie dodatkowe'
                    ]);
            }
            else
            {
                $form->remove('division');
                $form->remove('additionalTraining');
            }
        };
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier, $options) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data['kindOfTraining']);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('kindOfTraining', null);
    }
}