<?php

namespace App\Controller\Admin;

use App\Entity\Pharmacist;
use App\Entity\User;
use App\Form\PharmacistType;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Admin/pharmacistProfile")
 */
class PharmacistProfileController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * PharmacistProfileController constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="pharmacistProfile_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        $user=$this->getUser();
        $pharmacist= $userRepository->find($user);
        if (empty( $pharmacist->getInfoPharmacist()))
        {
            return  $this->redirectToRoute('pharmacistprofile_new');
        }

        return $this->render('admin/pharmacistProfile/index.html.twig', [
            'users' => $pharmacist,
        ]);
    }

    /**
     * @Route("/new", name="pharmacistprofile_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user=$this->getUser();
        $pharmacist = new Pharmacist();
        $pharmacist->setPharmacistUser($user);
        $form = $this->createForm(PharmacistType::class, $pharmacist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
            $this->manager->persist($pharmacist);
            $this->manager->flush();

            return $this->redirectToRoute('pharmacistProfile_index');
        }

        return $this->render('admin/pharmacistProfile/new.html.twig', [
            'pharmacist' => $pharmacist,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}", name="user_show", methods={"GET"})
//     */
//    public function show(User $user): Response
//    {
//        return $this->render('user/show.html.twig', [
//            'user' => $user,
//        ]);
//    }

    /**
     * @Route("/{id}/edit", name="pharmacistprofile_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pharmacistProfile_index');
        }

        return $this->render('admin/pharmacistProfile/edit.html.twig', [
            'user' => $user,
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
