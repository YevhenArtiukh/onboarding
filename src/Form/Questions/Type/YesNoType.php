<?php


namespace App\Form\Questions\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class YesNoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('yesno', ChoiceType::class, [
            'choices' => [
                'Tak' => true,
                'Nie' => false,
            ],
            'placeholder' => '',
            'choice_attr' => function() {
                return  ['class' => 'with-gap material-inputs radio-col-red'];
            },
            'attr' => [
                'class' => 'mt-1 d-flex flex-column flex-sm-row position-relative'
            ],
            'row_attr' => [
                'class' => 'form-group mb-4'
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => false,
        ]);

    }
}