<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('password')
            ->add('age')
            ->add('roles',ChoiceType::class)
//            ->add('roles',ChoiceType::class,
//                ['choices' => [
//        'Doctor' => 'ROLE_DOCTOR',
//        'Patient' => "ROLE_PATIENT",
//        'Pharmacist' => 'ROLE_PHARMACIST',
//    ],
//                'multiple' => true,])

            ->add('email',EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
