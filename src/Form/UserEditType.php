<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('firstname')
            ->add('lastname')
            ->add('title')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('phone')
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'placeholder' => 'Select role...',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('status', ChoiceType::class,[
                'choices' => [
                    "Active" => "active",
                    "Disable" => "disable",
                    "Pending" => "pending"
                ]
            ])
        ;

            /*$builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['edit'],
        ]);
    }
}
