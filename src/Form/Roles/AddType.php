<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 15:12
 */

namespace App\Form\Roles;


use App\Entity\Permissions\Permission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
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
                'label' => 'Nazwa roli'
            ])
            ->add('permissions', EntityType::class, [
                'class' => Permission::class,
                'choice_label' => function (Permission $permission) {
                    return $permission->getName();
                },
                'choice_attr' => function($choice, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'material-inputs filled-in chk-col-light-blue'];
                },
                'multiple' => true,
                'expanded' => true,
                'label' => false
            ])
            ;
    }
}