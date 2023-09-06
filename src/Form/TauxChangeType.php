<?php

namespace App\Form;

use App\Entity\TauxChange;
use App\Entity\CryptoMonnaie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TauxChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('monnaie_fiduciaire', ChoiceType::class, [
                'choices'=> [
                    'EURO' => '€',
                    'DOLLAR' => '$',
                    'Frs CFA' => 'XOF',
                    'NAIRA' => 'NGN']
            ])
            ->add('taux_change_now')
            
            ->add('crypto', EntityType::class, [
                'class' => CryptoMonnaie::class,
                'choice_label'=>'symbole'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TauxChange::class,
        ]);
    }
}
