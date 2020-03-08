<?php

namespace App\DataFixtures;

use App\Entity\Doctor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class DoctorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i=0; $i<50;$i++)
        {
            $doctor=new Doctor();

            $doctor
                ->setDepartment($faker->address)
                ->setName($faker->name)
                ->setType($faker->words)
                ->setMobile($faker->phoneNumber)
                ->setEmail($faker->email)
                ->setHospitalName($faker->company)

                ->setSpecialization($faker->domainName);

            $manager->persist($doctor);

        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
