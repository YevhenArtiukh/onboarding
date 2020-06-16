<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 11:13
 */

namespace App\Form\Security;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordResetChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Hasło',
                    'onInput' => 'checkPassword();',
                    'pattern' => "(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#+=._-]).{8,}"
                ],
                'row_attr' => [
                    'class' => 'col-12'
                ],
                'label' => false
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form-horizontal mt-3 form-material'
            ]
        ]);
    }
}