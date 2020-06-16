<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:01
 */

namespace App\Form\Exams;


use App\Entity\Exams\Exam\Type;
use App\Entity\Trainings\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
                'label' => 'Nazwa'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    Type::TYPE_TEST => Type::TYPE_TEST,
                    Type::TYPE_ANKIETA => Type::TYPE_ANKIETA
                ],
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Rodzaj '
            ])
            ->add('duration', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'readonly' => true
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'html5' => true,
                'label' => 'Czas trwania (min)',

            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Aktywny' => true,
                    'Nieaktywny' => false
                ],
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Status'
            ])
        ;
    }
}