<?php

namespace App\DataFixtures;

use App\Entity\MedicPrescription;
use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class MedicPrescriptionFixtures extends Fixture implements DependentFixtureInterface
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
                ->setDateOfBirth($faker->dateTime($max = 'now', $timezone = null))
                ->setDiagnostic($faker->words(3,true))
                ->setDrug($faker->numberBetween(4,10))
                ->setDosage($faker->numberBetween(100,500))
                ->setExamination($faker->words(4,true))
                ->setHealthRegine($faker->realText($maxNbChars = 200, $indexSize = 2))
                ->setUnite($faker->numberBetween(2,4))
                ->setPulseRate($faker->biasedNumberBetween($min = 30, $max = 50, $function = 'sqrt')
                )
//                ->setDoctorId($this->getReference('user.demo'));

          ->setDoctorId($this->getReference(DoctorFixtures::DOCTOR_NAME));

            $manager->persist($prescription);

        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            DoctorFixtures::class,
        );
        // TODO: Implement getDependencies() method.
    }
}
