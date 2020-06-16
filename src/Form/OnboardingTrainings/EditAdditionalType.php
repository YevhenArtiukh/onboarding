<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 13:00
 */

namespace App\Form\OnboardingTrainings;


use App\Entity\OnboardingTrainings\OnboardingTraining\Type;
use App\Entity\Trainings\Training;
use App\Entity\Users\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAdditionalType extends AbstractType
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
                    return $entityRepository->createQueryBuilder('t')
                        ->innerJoin('t.divisions', 'd', Join::WITH, 'd.id = :division')
                        ->where('t.kindOfTraining = :kindOfTraining')
                        ->andWhere('t.isAdditional = true')
                        ->setParameter('kindOfTraining', $options['status'])
                        ->setParameter('division', $options['division']);
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
            ->add('coaches', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getFullName();
                },
                'query_builder' => function(EntityRepository $entityRepository) {
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
            ])
            ->add('day', ChoiceType::class, [
                'choices' => [
                    14 => 14,
                    30 => 30,
                    90 => 90
                ],
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Termin realizacji'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'status' => '',
            'division' => null
        ]);
    }
}