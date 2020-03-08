<?php

namespace App\DataFixtures;

use App\Entity\MedicPrescription;
use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class MedicPrescriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i=0; $i<50;$i++)
        {
            $prescription=new MedicPrescription();

            $prescription
                ->setBloodPressure($faker->address)
                ->setAge($faker->year($max = 'now') )
                ->setContact($faker->phoneNumber)
                ->setDateOfBirth($faker->date($format = 'Y-m-d', $max = 'now'))
                ->setDiagnostic($faker->words(3,true))
                ->setDrug($faker->numberBetween(4,10))
                ->setExamination($faker->words(4,true))
                ->setHealthRegine($faker->realText($maxNbChars = 200, $indexSize = 2))
                ->setUnite($faker->numberBetween(2,4))
                ->setPulseRate($faker->biasedNumberBetween($min = 30, $max = 50, $function = 'sqrt')
                );
            $manager->persist($prescription);

        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
