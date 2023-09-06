<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('nom')
            ->add('prenoms')
            ->add('ville')
            ->add('pays')
            ->add('date_naissance')
            ->add('id_card')
            ->add('contacts')
            ->add('sponsor')
            ->add('roles')
            ->add('is_verified')
            ->add('resetToken')
            ->add('compte')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
