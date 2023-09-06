<?php

namespace App\Form;

use App\Entity\CryptoMonnaie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CryptoMonnaieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('crypto_name', TextType::class, [
                'attr'=> ['class'=>'form-control']
            ])
            ->add('symbole', TextType::class, [
                'attr'=> ['class'=>'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CryptoMonnaie::class,
        ]);
    }
}
