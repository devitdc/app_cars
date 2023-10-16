<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAddType extends AbstractType
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
            ->add('password', PasswordType::class)
            ->add('passwordMatch', PasswordType::class)
            ->add('status', ChoiceType::class,[
                'choices' => [
                    "Active" => "active",
                    "Disable" => "disable",
                    "Pending" => "pending"
                ]
            ])
            ->add('phone')
            ->add('role', EntityType::class,[
                'class' => Role::class,
                'choice_label' => 'name',
                'placeholder' => 'Select role...'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
