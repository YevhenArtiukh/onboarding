<?php


namespace App\Form\Exams;


use App\Entity\Exams\Exam\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
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
                'label' => 'Rodzaj',
                'disabled' => true
            ])
            ->add('duration', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'readonly' => $this->getReadonlyStatus($options['type'])
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
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'type' => null,
        ]);
    }

    public function getReadonlyStatus(?string $type)
    {
        if($type == Type::TYPE_TEST)
            return false;
                else
                    return true;
    }
}