<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-04
 * Time: 13:52
 */

namespace App\Form\PresenceParticipants;


use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Trainings\Training;
use App\Entity\Users\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CoachingSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('t')
                        ->leftJoin(OnboardingTraining::class, 'ot', Join::WITH, 't.id = ot.training')
                        ->where('ot.type = :type')
                        ->setParameter('type', OnboardingTraining\Type::TYPE_PRESENCE)
                        ->orderBy('t.name');

                },
                'choice_label' => function (Training $training) {
                    return $training->getName();
                },
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'placeholder' => '',
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label_attr' => [
                    'class' => 'number'
                ],
                'label' => 'Nazwa szkolenia'
            ])
            ->add('coach', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getName() . ' ' . $user->getSurname();
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label_attr' => [
                    'class' => 'number'
                ],
                'label' => 'Imię i nazwisko trenera'
            ])
            ->add('date', TextType::class, [
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
                'label' => 'Data szkolenia'
            ]);
    }
}