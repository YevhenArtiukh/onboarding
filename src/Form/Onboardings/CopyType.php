<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-20
 * Time: 14:58
 */

namespace App\Form\Onboardings;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CopyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('copy', SubmitType::class, [
                'attr' => [
                    'class' => 'btn waves-effect waves-light btn-info ml-1',
                    'disabled' => $options['disabled']
                ],
                'label' => 'Kopiuj poprzedni'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'disabled' => true
        ]);
    }
}