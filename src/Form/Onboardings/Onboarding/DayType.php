<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:10
 */

namespace App\Form\Onboardings\Onboarding;


use App\Entity\Places\Place;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', TextType::class, [
                'attr' => [
                    'class' => 'form-control date',
                    'readonly' => true
                ],
                'row_attr' => [
                    'class' => 'form-group col-3'
                ],
                'label_attr' => [
                    'class' => 'number'
                ],
                'label' => 'dzień'
            ])
            ->add('place', EntityType::class, [
                'class' => Place::class,
                'choice_label' => function (Place $place) {
                    return $place->getName();
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group col-5'
                ],
                'label' => 'Miejsce szkolenia'
            ])
            ->add('hall', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group col-2'
                ],
                'label' => 'Sala'
            ])
            ->add('delete', ButtonType::class, [
                'row_attr' => [
                    'class' => 'col-2 form-group d-flex align-items-center'
                ],
                'attr' => [
                    'class' => 'btn waves-effect waves-light btn-danger',
                    'onClick' => 'deleteDay(this.id);'
                ],
                'label' => 'Usuń'
            ])
            ;
    }
}