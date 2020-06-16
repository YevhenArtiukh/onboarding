<?php


namespace App\Form\TrainingAttachments;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'required' => true,
                'attr' => [
                    'name' => 'file',
                    'class' => 'dropify'
//                    'style' => 'display:none;'
                ],
                'row_attr' => [
                    'class' => 'form-group text-important'
                ],
                'label' => false
            ]);
    }
}