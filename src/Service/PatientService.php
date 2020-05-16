<?php


namespace App\Service;


use App\Repository\PatientRepository;
use Symfony\Component\Security\Core\Security;

class PatientService
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var PatientRepository
     */
    private $patientRepository;

    public function __construct(Security $security, PatientRepository $patientRepository)
    {

        $this->security = $security;
        $this->patientRepository = $patientRepository;
    }
    public function getInfoPatient()
    {
        $user=$this->security->getUser();
        return $patient=$this->patientRepository->find($user);
    }

}