<?php


namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcher ;

class UserRegisterEvent extends EventDispatcher
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


}