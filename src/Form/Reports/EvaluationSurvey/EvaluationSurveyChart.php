<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-02
 * Time: 14:51
 */

namespace App\Form\Reports\EvaluationSurvey;


use App\Entity\Exams\Exam\Type;
use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Trainings\Training;
use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire;
use App\Entity\UserResults\UserResult;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class EvaluationSurveyChart extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', EntityType::class, [
                'class' => Onboarding::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('o')
                        ->orderBy("STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y')", 'DESC');
                },
                'choice_label' => function (Onboarding $onboarding) {
                    return $onboarding->getDateStart()->format('d.m.Y');
                },
                'placeholder' => '',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Data onboardingu:'
            ])
            ->add('question', EntityType::class, [
                'class' => UserAnswerQuestionnaire::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('uaq')
                        ->where('uaq.id IS NULL');
                },
                'choice_label' => function (UserAnswerQuestionnaire $userAnswerQuestionnaire) {
                    return $userAnswerQuestionnaire->getQuestion();
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Pytanie:'
            ])
            ;

        $formModifier = function (
            FormInterface $form,
            ?string $onboardingId
        ){
            $form
                ->add('question', EntityType::class, [
                    'class' => UserAnswerQuestionnaire::class,
                    'query_builder' => function (EntityRepository $entityRepository) use ($onboardingId) {
                        if($onboardingId) {
                            return $entityRepository->createQueryBuilder('uaq')
                                ->leftJoin(UserResult::class, 'ur', Join::WITH, 'uaq.userResult = ur.id')
                                ->leftJoin(OnboardingTraining::class, 'ot', Join::WITH, 'ur.onboardingTraining = ot.id')
                                ->leftJoin(Onboarding::class, 'o', Join::WITH, 'ot.onboarding = o.id')
                                ->leftJoin(Training::class, 't', Join::WITH, 'ot.training = t.id')
                                ->where('t.isEvaluationSurvey = TRUE')
                                ->andWhere('o.id = :onboardingId')
                                ->andWhere("(uaq.questionType = :rating OR uaq.questionType = :yesNo)")
                                ->setParameter('onboardingId', $onboardingId)
                                ->setParameter('rating', Type::ANSWER_TYPE_RATING)
                                ->setParameter('yesNo', Type::ANSWER_TYPE_YES_NO)
                                ->groupBy('uaq.question');
                        } else {
                            return $entityRepository->createQueryBuilder('uaq')
                                ->where('uaq.id IS NULL');
                        }
                    },
                    'choice_label' => function (UserAnswerQuestionnaire $userAnswerQuestionnaire) {
                        return $userAnswerQuestionnaire->getQuestion();
                    },
                    'choice_value' => function (?UserAnswerQuestionnaire $userAnswerQuestionnaire) {
                        return $userAnswerQuestionnaire?$userAnswerQuestionnaire->getQuestion(): '';
                    },
                    'placeholder' => '',
                    'attr' => [
                        'class' => 'form-control',
                        'onchange' => 'questionChange()'
                    ],
                    'row_attr' => [
                        'class' => 'form-group'
                    ],
                    'label' => 'Data od:'
                ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier, $options) {
                $onboardingId = $event->getData()["date"];
                $formModifier(
                    $event->getForm(),
                    $onboardingId
                );
            }
        );
    }
}