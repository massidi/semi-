<?php

namespace App\Controller\Admin;

use App\Entity\Doctor;
use App\Entity\User;
use App\Form\DoctorType;
use App\Form\User1Type;
use App\Form\UserProfileType;
use App\Repository\DoctorRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Admin/userProfile")
 */
class UserProfileController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function index(UserRepository $userRepository,DoctorRepository $doctorRepository): Response

    {
        $user= $this->getUser();
        return $this->render('admin/userProfile/index.html.twig', [
            'users' => $userRepository->find($user)
        ]);
    }


    /**
     * @Route("/show/{id}", name="user_show", methods={"GET"})
     * @param $id
     * @param UserRepository $userRepository
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function show($id,UserRepository $userRepository,DoctorRepository $doctorRepository): Response
    {          $user= $this->getUser();

//    dd($userProfile);
        $userProfile= $doctorRepository->findOneBy();
        return $this->render('admin/userProfile/show.html.twig', [
            'userProfile' => $userProfile,
        ]);
    }

    /**
     * @Route("/new",name="new")
     * @param Request $request
     * @param DoctorRepository $doctorRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function new(Request $request, DoctorRepository $doctorRepository)
    {

        $users= $this->getUser();
        $doctors= new Doctor();

       $doctors->setDoctorUser($users);




        $form = $this->createForm(DoctorType::class, $doctors);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($doctors);
            $entityManager->flush();

            return $this->redirectToRoute('user_show');

        }

        return $this->render('admin/userProfile/new.html.twig', ['form' => $form->createView(),
            'doctors' => $doctors,]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request,User $user): Response
    {
//        $user=$this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show');
        }

        return $this->render('admin/userProfile/edit.html.twig', [
            'userProfile' => $user,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}", name="user_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, User $user): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($user);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('user_index');
//    }
}