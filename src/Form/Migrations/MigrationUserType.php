<?php


namespace App\Form\Migrations;


use App\Entity\Departments\Department;
use App\Entity\Users\User\FormOfEmployment;
use App\Entity\Users\User\TypeOfWorker;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MigrationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('d')
                        ->where('d.division = :division')
                        ->orderBy('d.parent', 'ASC')
                        ->setParameter('division', $options['division']);
                },
                'choice_label' => function (Department $department) {
                    return $department->getName();
                },
                'placeholder' => '',
                'group_by' => 'parent.name',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Obszar'
            ])
            ->add('position', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Stanowisko'
            ])
            ->add('formOfEmployment', ChoiceType::class, [
                'choices' => [
                    'internal' => FormOfEmployment::FORM_OF_EMPLOYMENT_INTERNAL,
                    'external' => FormOfEmployment::FORM_OF_EMPLOYMENT_EXTERNAL,
                    'Umowa zlecenie' => FormOfEmployment::FORM_OF_EMPLOYMENT_ORDER
                ],
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Forma zatrudnienia'
            ])
            ->add('typeOfWorker', ChoiceType::class, [
                'choices' => [
                    'biurowy' => TypeOfWorker::TYPE_OF_WORKER_OFFICE,
                    'terenowy' => TypeOfWorker::TYPE_OF_WORKER_FIELD
                ],
                'placeholder' => '',
                'attr' => [
                    'class' => 'select2 form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Pracownik'
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'E-mail'
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'division' => null
        ]);
    }
}