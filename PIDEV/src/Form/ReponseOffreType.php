<?php

namespace App\Form;

use App\Entity\AppelOffre;
use App\Entity\ReponseOffre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReponseOffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('budget')
            ->add('etat')
            ->add('id_offre', EntityType::class, [
                'class'=> AppelOffre::class,
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
            'data_class' => ReponseOffre::class,
        ]);
    }
}
