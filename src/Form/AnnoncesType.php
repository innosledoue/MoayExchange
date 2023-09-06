<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\CryptoMonnaie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant_dispo', TextType::class, [
                'attr'=> ['class'=>'form-control']
            ])
            ->add('prix', TextType::class, [
                'attr'=> ['class'=>'form-control']
            ])
            ->add('type_annonce', ChoiceType::class, [
                'choices'=> [
                    'VENTE' => 'Vente',
                    'ACHAT' => 'Achat'
                ]
            ])
            //->add('created_at')
            //->add('user')
            ->add('crypto', EntityType::class, [
                'class'=> CryptoMonnaie::class,
                'choice_label'=>'symbole'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
