<?php

namespace App\Form;

use App\Entity\CryptoMonnaie;
use App\Entity\Transactions;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('type_transaction', ChoiceType::class, [
            //     'choices' => [
            //         'Transfert' => 'transfert']
            // ])
            ->add('montant', TextType::class,[
                'attr'=> ['class'=>'form-control']
            ])
            ->add('crypto', EntityType::class, [
                'class'=> CryptoMonnaie::class,
                'choice_label'=>'symbole'
            ])
            ->add('recepteur',EntityType::class, [
                'class'=> User::class,
                'choice_label'=>'username'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transactions::class,
        ]);
    }
}
