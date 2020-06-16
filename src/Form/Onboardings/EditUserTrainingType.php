<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 14:23
 */

namespace App\Form\Onboardings;


use App\Entity\Divisions\Division;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Trainings\Training;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('checkAll', ButtonType::class, [
                'attr' => [
                    'class' => 'btn btn-info'
                ],
                'label' => 'Zaznacz wszystkie'
            ])
            ->add('uncheckAll', ButtonType::class, [
                'attr' => [
                    'class' => 'btn btn-info'
                ],
                'label' => 'Odznacz wszystkie'
            ])
            ->add('onboardingTrainings', EntityType::class, [
                'class' => OnboardingTraining::class,
                'choice_label' => function (OnboardingTraining $onboardingTraining) {
                    $isAdditional = $onboardingTraining->getTraining()->getIsAdditional()?' | dodatkowe':'';
                    return $onboardingTraining->getTraining()->getName().$isAdditional;
                },
                'choice_attr' => function($choice, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'material-inputs filled-in chk-col-light-blue'];
                },
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('ot')
                        ->leftJoin(Training::class, 't', Join::WITH, 'ot.training = t.id')
                        ->leftJoin(Division::class, 'd', Join::WITH, 'ot.division = d.id')
                        ->where('ot.onboarding = :onboarding')
                        ->andWhere("(t.kindOfTraining = :generalType) OR (t.kindOfTraining = :divisionType AND d = :division)")
                        ->setParameter('onboarding', $options['onboarding'])
                        ->setParameter('generalType', 'general')
                        ->setParameter('divisionType', 'division')
                        ->setParameter('division', $options['division'])
                        ->orderBy('t.isAdditional', 'ASC')
                        ->addOrderBy('ot.day', 'ASC');
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'onboarding' => null,
            'division' => null
        ]);
    }
}