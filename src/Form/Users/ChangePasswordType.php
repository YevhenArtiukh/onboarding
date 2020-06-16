<?php


namespace App\Form\Users;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true
                ],
                'label' => 'Skopiuj hasło '
            ]);
    }
}