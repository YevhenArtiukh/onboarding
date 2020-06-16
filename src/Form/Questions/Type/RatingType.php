<?php


namespace App\Form\Questions\Type;


use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('choices', ChoiceType::class, [
            'choices' => [
                'Bardzo źle' => Rating::RATING_VERY_BAD,
                'Źle' => Rating::RATING_BAD,
                'Przeciętne' => Rating::RATING_MIDDLE,
                'Dobrze' => Rating::RATING_GOOD,
                'Bardzo dobrze' => Rating::RATING_VERY_GOOD
            ],
            'placeholder' => '',
            'choice_attr' => function () {
                return ['class' => 'with-gap material-inputs material-inputs radio-col-red'];
            },
            'attr' => [
                'class' => 'mt-1 d-flex flex-column flex-sm-row align-item-center justify-content-between position-relative'
            ],
            'row_attr' => [
                'class' => 'form-group mb-4'
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => false
        ]);

    }
}