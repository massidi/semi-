<?php


namespace App\Event;


use App\Entity\MedicPrescription;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;


class UserRegisterEvent extends Event
{
    const  Name = 'user.register';
    /**
     * @var User
     */
    private $registerUser;

    public function __construct(User $registerUser)
   {
       $this->registerUser = $registerUser;

   }

    /**
     * @return User
     */
    public function getRegisterUser(): User
    {
        return $this->registerUser;
    }

//    /**
//     * @return MedicPrescription
//     */
//    public  function  getMedication():MedicPrescription
//    {
//        return $this->medicprescription;
//    }


}