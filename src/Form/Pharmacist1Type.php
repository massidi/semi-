<?php

namespace App\Form;

use App\Entity\Pharmacist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Pharmacist1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('certificate')
            ->add('pharmacy_name')
            ->add('type')
            ->add('address')
            ->add('mobile')
            ->add('email')
            ->add('image')
            ->add('pharmacistUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pharmacist::class,
        ]);
    }
}
