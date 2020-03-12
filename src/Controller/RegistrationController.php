<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserRegisterEvent;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\Common\Persistence\ObjectManager;
//use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $manager;

    public  function  __construct(EntityManagerInterface $manager)
    {

        $this->manager=$manager;
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EventDispatcherInterface $eventDispatcher
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,EventDispatcherInterface $eventDispatcher): Response
    {
        $users = new User();
        $form = $this->createForm(RegistrationFormType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /////// encode the plain password///////////
            /// //////////////////////////////////////
            $users->setPassword(
                $passwordEncoder->encodePassword(
                    $users,
                    $form->get('plainPassword')->getData()
                )
            );


            $this->manager->persist($users);
            $this->manager->flush();
            // do anything else you need here, like send an email
            $userRegister= new UserRegisterEvent($users);
            $eventDispatcher->dispatch($userRegister, UserRegisterEvent::Name);
            ///////////send email//////////////////

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
/*
    /**
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    /* public function login( UserPasswordEncoderInterface $passwordEncoder)
    {
        $users= new  User();
        /* $users->setFirstName();
         $users->setPassword($this->encoder->encodePassword($users,$users->getPlainPassword()));
        */
       /* $password = $passwordEncoder->encodePassword($users, $users->getPlainPassword());
        $users->setPassword($password);
        $this->manager->persist($users);

        $this->manager->flush();
    }*/
}
