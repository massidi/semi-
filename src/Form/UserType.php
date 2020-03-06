<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('email')
            ->add('status',ChoiceType::class
            ,['choices' =>[
                'patient' => 'ROLE_USER',
                    'DOCTOR' => 'ROLE_ADMIN',
                    'PHARMACIST' => 'ROLE_ADMIN'
    ],
                    'expanded' => true,
                    'multiple'=>true])
            ->add('username')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
