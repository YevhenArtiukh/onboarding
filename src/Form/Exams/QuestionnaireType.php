<?php


namespace App\Form\Exams;


use App\Entity\Exams\Exam\Type;
use App\Entity\Questions\Question;
use App\Form\Questions\Type\CommentType;
use App\Form\Questions\Type\RatingCommentType;
use App\Form\Questions\Type\RatingType;
use App\Form\Questions\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $questionKey= 1;
        /** @var Question $question */
        foreach ($options['questions'] as  $key => $question)
        {


            if($question->getType() == Type::ANSWER_TYPE_RATING)
                $builder->add($question->getId(), RatingType::class, [ 'label' => $questionKey.'. '.$question->getName()]);
            elseif($question->getType() == Type::ANSWER_TYPE_COMMENT)
                $builder->add($question->getId(), CommentType::class, [ 'label' => $questionKey.'. '.$question->getName()]);
            elseif($question->getType() == Type::ANSWER_TYPE_YES_NO)
                $builder->add($question->getId(), YesNoType::class, [ 'label' => $questionKey.'. '.$question->getName()]);
            else
                $builder->add($question->getId(), RatingCommentType::class, [ 'label' => $questionKey.'. '.$question->getName()]);

            $questionKey++;
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('questions', []);
    }


}