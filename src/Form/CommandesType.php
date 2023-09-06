<?php

namespace App\Form;

use App\Entity\Commandes;
use App\Entity\CryptoMonnaie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montantEnvoye')
            ->add('montantRecevoir')
            ->add('adresseReception')
            // ->add('adresseEnvoyeur')
            ->add('je_donne',EntityType::class, [
                'class'=> CryptoMonnaie::class,
                'choice_label'=>'symbole'
            ])
            ->add('je_recois', EntityType::class, [
                'class'=> CryptoMonnaie::class,
                'choice_label'=>'symbole'
                ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commandes::class,
        ]);
    }
}
