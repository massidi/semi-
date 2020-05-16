<?php


namespace App\Service;
use App\Repository\DoctorRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class DoctorService
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var DoctorRepository
     */
    private $doctorRepository;

    public function __construct(Security $security,UserRepository $userRepository,DoctorRepository $doctorRepository)
    {

        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->doctorRepository = $doctorRepository;
    }
    public  function getInfoDoctor()
    {
     $users= $this->security->getUser();
        /** @var TYPE_NAME $doctor */
        $doctor=$this->doctorRepository->find($users);

      return $doctor;

    }


}