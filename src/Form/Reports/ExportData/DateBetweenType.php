<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-28
 * Time: 12:06
 */

namespace App\Form\Reports\ExportData;


use App\Entity\Onboardings\Onboarding;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DateBetweenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', EntityType::class, [
                'class' => Onboarding::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('o')
                        ->orderBy("STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y')", 'DESC');
                },
                'choice_label' => function (Onboarding $onboarding) {
                    return $onboarding->getDateStart()->format('d.m.Y');
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label_attr' => [
                    'class' => 'number'
                ],
                'label' => 'Data od:'
            ])
            ->add('dateEnd', EntityType::class, [
                'class' => Onboarding::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('o')
                        ->orderBy("STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y')", 'DESC');
                },
                'choice_label' => function (Onboarding $onboarding) {
                    return $onboarding->getDateStart()->format('d.m.Y');
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label_attr' => [
                    'class' => 'number'
                ],
                'label' => 'Data do:'
            ])
            ;
    }
}