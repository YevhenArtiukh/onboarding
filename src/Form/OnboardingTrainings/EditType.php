<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:13
 */

namespace App\Form\OnboardingTrainings;


use App\Entity\Onboardings\Onboarding\Status;
use App\Entity\OnboardingTrainings\OnboardingTraining\Type;
use App\Entity\Trainings\Training;
use App\Entity\Users\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => function (Training $training) {
                    return $training->getName();
                },
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    switch ($options['status']) {
                        case Status::STATUS_GENERAL:
                            return $entityRepository->createQueryBuilder('t')
                                ->where('t.kindOfTraining = :kindOfTraining')
                                ->andWhere('t.isAdditional = false')
                                ->setParameter('kindOfTraining', $options['status']);
                            break;
                        case Status::STATUS_DIVISION:
                            return $entityRepository->createQueryBuilder('t')
                                ->innerJoin('t.divisions', 'd', Join::WITH, 'd.id = :division')
                                ->where('t.kindOfTraining = :kindOfTraining')
                                ->andWhere('t.isAdditional = false')
                                ->setParameter('kindOfTraining', $options['status'])
                                ->setParameter('division', $options['division']);
                            break;
                    }
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Szkolenie'
            ])
            ->add('day', ChoiceType::class, [
                'choices' => $options['range'],
                'choice_label' => function (int $choice) {
                    return $choice;
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Termin realizacji'
            ])
            ->add('time', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => (new \DateTime('now'))->format('H:i'),
                    'pattern' => "^([0-1][0-9]|[2][0-3]):([0-5][0-9])$"
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Godzina rozpoczęcia'
            ]);

        $formModifier = function (
            FormInterface $form,
            Training $training
        ) {
            if ($training->getTypeOfTraining() === Training\TypeOfTraining::TYPE_OF_TRAINING_PAUSE) {
                $form
                    ->remove('coaches')
                    ->remove('type');
            } else {
                $form
                    ->add('coaches', EntityType::class, [
                        'class' => User::class,
                        'choice_label' => function (User $user) {
                            return $user->getFullName();
                        },
                        'query_builder' => function (EntityRepository $entityRepository) {
                            return $entityRepository->createQueryBuilder('u')
                                ->innerJoin('u.roles', 'r', Join::WITH, 'r.name = :role')
                                ->setParameter('role', 'Trener');
                        },
                        'multiple' => true,
                        'placeholder' => '',
                        'attr' => [
                            'class' => 'select2 form-control'
                        ],
                        'row_attr' => [
                            'class' => 'form-group'
                        ],
                        'label' => 'Trener'
                    ])
                    ->add('type', ChoiceType::class, [
                        'choices' => [
                            Type::TYPE_TEST => Type::TYPE_TEST,
                            Type::TYPE_PRESENCE => Type::TYPE_PRESENCE
                        ],
                        'placeholder' => '',
                        'attr' => [
                            'class' => 'select2 form-control'
                        ],
                        'row_attr' => [
                            'class' => 'form-group'
                        ],
                        'label' => 'Rodzaj zaliczenia'
                    ]);
            }
        };
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier, $options) {
                $data = $event->getData();
                $training = $options['trainingRepository']->findOneById((int)$data['training']);
                if ($training)
                    $formModifier($event->getForm(), $training);
            }
        );

        if ($options['typeOfTraining'] !== Training\TypeOfTraining::TYPE_OF_TRAINING_PAUSE) {
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifier, $options) {
                    $form = $event->getForm();

                    $form
                        ->add('coaches', EntityType::class, [
                            'class' => User::class,
                            'choice_label' => function (User $user) {
                                return $user->getFullName();
                            },
                            'query_builder' => function (EntityRepository $entityRepository) {
                                return $entityRepository->createQueryBuilder('u')
                                    ->innerJoin('u.roles', 'r', Join::WITH, 'r.name = :role')
                                    ->setParameter('role', 'Trener');
                            },
                            'multiple' => true,
                            'placeholder' => '',
                            'attr' => [
                                'class' => 'select2 form-control'
                            ],
                            'row_attr' => [
                                'class' => 'form-group'
                            ],
                            'label' => 'Trener'
                        ])
                        ->add('type', ChoiceType::class, [
                            'choices' => [
                                Type::TYPE_TEST => Type::TYPE_TEST,
                                Type::TYPE_PRESENCE => Type::TYPE_PRESENCE
                            ],
                            'placeholder' => '',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'row_attr' => [
                                'class' => 'form-group'
                            ],
                            'label' => 'Rodzaj zaliczenia'
                        ]);
                }
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'range' => null,
            'status' => '',
            'division' => null,
            'trainingRepository' => null,
            'typeOfTraining' => null
        ]);
    }
}