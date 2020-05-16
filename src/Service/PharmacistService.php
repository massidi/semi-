<?php


namespace App\Service;


use App\Repository\PharmacistRepository;
use Symfony\Component\Security\Core\Security;

class PharmacistService
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var PharmacistRepository
     */
    private $pharmacistRepository;

    public function __construct(Security $security, PharmacistRepository $pharmacistRepository)
    {
        $this->security = $security;
        $this->pharmacistRepository = $pharmacistRepository;
    }
    public function getInfoPharmacist()
    {
        $user=$this->security->getUser();
        return  $pharmacist=$this->pharmacistRepository->find($user);
    }

}