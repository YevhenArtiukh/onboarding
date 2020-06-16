<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 13:30
 */

namespace App\Form\Questions\Question;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ChoosesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-8 form-group'
                ],
                'label' => 'Odpowiedź'
            ])
            ->add('correct', CheckboxType::class, [
                'attr' => [
                    'class' => 'material-inputs filled-in chk-col-light-blue'
                ],
                'required' => false,
                'row_attr' => [
                    'class' => 'col-2 form-group d-flex align-items-center'
                ],
                'label' => 'Prawidłowa'
            ])
            ->add('delete', ButtonType::class, [
                'row_attr' => [
                    'class' => 'col-2 form-group d-flex align-items-center'
                ],
                'attr' => [
                    'class' => 'btn waves-effect waves-light btn-danger',
                    'onClick' => 'deleteAnswer(this.id);'
                ],
                'label' => 'Usuń'
            ])
            ;

    }
}