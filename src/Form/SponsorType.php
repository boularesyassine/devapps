<?php

namespace App\Form;

use App\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;
class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('email')
            ->add('numTel', IntegerType::class, [
                'label' => 'Postal Code',
                'required' => true,
                'attr' => [
                    'pattern' => '^[0-9]{8}$',
                    'title' => 'Please enter a valid phone number',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]{8}$/',
                        'message' => 'Please enter a valid phone number',
                    ]),
                ],
            ])
            ->add('Enregistrer',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}
