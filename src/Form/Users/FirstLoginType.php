<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 16:48
 */

namespace App\Form\Users;


use App\Entity\Roles\Role;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FirstLoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Hasło',
                    'onInput' => 'checkPassword();',
                    'pattern' => "(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#+=._-]).{8,}"
                ],
                'label' => false
            ])
            ->add('photo', FileType::class, [
                'row_attr' => [
                    'class' => 'd-none'
                ],
                'required' => false,
                'label' => false
            ])
        ;

        if(count($options['roles']) > 1) {
            $builder
                ->add('role', EntityType::class, [
                    'class' => Role::class,
                    'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                        return $entityRepository->createQueryBuilder('r')
                            ->where("r.name IN ('".implode("','",$options['roles'])."')")
                            ->orderBy('r.name', 'ASC');
                    },
                    'choice_label' => function (Role $role) {
                        return $role->getName();
                    },
                    'placeholder' => 'Wybierz rolę',
                    'row_attr' => [
                        'class' => 'from-group'
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => false
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'roles' => null,
            'attr' => [
                'class' => 'form-horizontal mt-3 form-material'
            ]
        ]);
    }
}