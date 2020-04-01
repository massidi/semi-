<?php


namespace App\Event;


use App\Entity\MedicPrescription;
//use App\Repository\MedicPrescriptionRepository;
use Symfony\Contracts\EventDispatcher\Event;

class MedicationEvent extends  Event
{
    const Name= 'medication.prescription';
    /**
     * @var MedicPrescription
     */
    private $medicPrescription;

    public function __construct(MedicPrescription $medicPrescription)
{
    $this->medicPrescription = $medicPrescription;
}

    /**
     * @return MedicPrescription
     */
    public function getMedicPrescription(): MedicPrescription
    {
        return $this->medicPrescription;
    }

}