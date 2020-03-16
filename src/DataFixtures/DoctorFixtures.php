<?php

namespace App\DataFixtures;

use App\Entity\Doctor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class DoctorFixtures extends Fixture
{
    public  const DOCTOR_NAME = 'doctor-user_';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $doctor = new Doctor();
            $doctor
                ->setDepartment($faker->address)
                ->setName($faker->name)
                ->setType($faker->domainWord)
                ->setMobile($faker->phoneNumber)
                ->setEmail($faker->email)
                ->setHospitalName($faker->company)
                ->setSpecialization($faker->domainName);

//            $this->addReference('user_demo_'.$i, $doctor);
            $this->addReference(self::DOCTOR_NAME .$i, $doctor);

            $manager->persist($doctor);
        }

        // $product = new Product();

        $manager->flush();
    }
}
