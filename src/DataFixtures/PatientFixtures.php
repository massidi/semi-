<?php

namespace App\DataFixtures;
use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i=0; $i<50;$i++)
        {
            $patient=new Patient();

            $patient
                ->setAddress($faker->address)
                ->setAge($faker->year($max = 'now') )
                ->setName($faker->name)
                ->setType($faker->domainName )
                ->setMobile($faker->phoneNumber)
                ->setWeigth($faker->biasedNumberBetween($min = 30, $max = 50, $function = 'sqrt')
                );
            $manager->persist($patient);

        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
