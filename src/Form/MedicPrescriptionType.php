<?php

namespace App\Form;

use App\Entity\MedicPrescription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicPrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOfBirth')
            ->add('age')
            ->add('contact')
            ->add('diagnostic')
            ->add('blood_pressure')
            ->add('pulse_rate')
            ->add('drug')
            ->add('unite')
            ->add('dosage')
            ->add('examination')
            ->add('health_regine')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MedicPrescription::class,
        ]);
    }
}
