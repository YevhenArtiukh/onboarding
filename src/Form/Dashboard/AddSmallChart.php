<?php


namespace App\Form\Dashboard;


use App\Entity\Widgets\Widget;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddSmallChart extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('widget', EntityType::class, [
                'class' => Widget::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    $qb = $er->createQueryBuilder('relUW');
                    $qbResult = $er->createQueryBuilder('w')
                        ->where('w.roleID = :roleID')
                        ->andWhere('w.chart = :chart')
                        ->setParameter('roleID', $options['roleID'])
                        ->setParameter('chart', $options['chart']);

                    if(!empty($options['widgets']))
                        $qbResult->andWhere($qb->expr()->notIn('w.id', $options['widgets']));

                    return $qbResult;

                },
                'choice_label' => function ($widget) {
                    /** @var Widget $widget */
                    return $widget->getTitle();
                },
                'attr' => [
                    'class' => 'form-control form-border'
                ],

                'label' => 'Wybierz widget',
                'required' => true,
                'placeholder' => ''
            ])
            ->add('position', HiddenType::class);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'roleID' => null,
            'chart' => null,
            'widgets' => []
        ]);
    }

}