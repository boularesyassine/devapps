<?php

namespace App\Form;


use App\Entity\AppelOffre;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AppelOffreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom')
        ->add('quantite')
        ->add('budget')
        ->add('description')
        ->add('id_utilisateur', EntityType::class, [
            'class'=> Utilisateur::class,
            'choice_label' => 'id'
        ])
        ->add('id_categorie', EntityType::class, [
            'class'=> Categorie::class,
            'choice_label' => 'id'
        ])
        ->add('save',SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary',
            ]
        ])

    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
