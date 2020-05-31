<?php

namespace App\Form;

use App\Entity\MedicPrescription;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Types\Context;
use Svg\Tag\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicPrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('createdAt'
//                , DateType::class, [
//                    'placeholder' => [
//                        'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
//                    ]
////                    'widget' => 'single_text',
////                    // this is actually the default format for single_text
////                    'format' => 'yyyy-MM-dd',
//                ])
            ->add('age')
            ->add('contact')
            ->add('diagnostic')
            ->add('blood_pressure')
            ->add('pulse_rate')
            ->add('drug',CKEditorType::class)
            ->add('examination',CKEditorType::class)
            ->add('health_regine',TextareaType::class)
            ->add('patientName')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MedicPrescription::class,
        ]);
    }
}
