<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils,Request $request)
    {
        $error= $authenticationUtils->getLastAuthenticationError();

        $LastUsername=$authenticationUtils->getLastUsername();

        return $this->render('security/login.htm.twig',[
        'error'=>$error,
            'last_username'=>$LastUsername

        ]);


    }
    public function login1(ObjectManager $manager,UserPasswordEncoderInterface $passwordEncoder)
    {
        $users= new  User();
       /* $users->setFirstName();
        $users->setPassword($this->encoder->encodePassword($users,$users->getPlainPassword()));
*/
        $password = $passwordEncoder->encodePassword($users, $users->getPlainPassword());
        $users->setPassword($password);
        $manager->persist($users);

        $manager->flush();
    }
}
