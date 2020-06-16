<?php


namespace App\Form\Users;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', FileType::class, [
                'required' => false,
                'attr' => [
                    'name' => 'file',
                    'style' => 'display:none;'
                ],
                'label' => false
            ]);
    }
}