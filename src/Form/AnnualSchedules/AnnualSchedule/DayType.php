<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-13
 * Time: 15:45
 */

namespace App\Form\AnnualSchedules\AnnualSchedule;


use App\Entity\Divisions\Division;
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
            ->add('division', EntityType::class, [
                'class' => Division::class,
                'choice_label' => function (Division $division) {
                    return $division->getName();
                },
                'attr' => [
                    'class' => 'form-control',
                    'onchange' => 'blockDivision();'
                ],
                'placeholder' => '',
                'row_attr' => [
                    'class' => 'form-group col-4'
                ],
                'label' => 'Dywizja'
            ])
            ->add('dateStart', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group col-3'
                ],
                'label' => 'Data od:'
            ])
            ->add('dateEnd', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group col-3'
                ],
                'label' => 'Data do:'
            ])
            ->add('delete', ButtonType::class, [
                'row_attr' => [
                    'class' => 'col-2 form-group d-flex',
                    'style' => 'align-items: flex-end;'
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