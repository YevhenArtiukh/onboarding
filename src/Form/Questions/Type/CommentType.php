<?php


namespace App\Form\Questions\Type;


use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mt-1 ',
                    'row' => 3

                ],
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => false
            ]);

    }
}