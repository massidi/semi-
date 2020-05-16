<?php

namespace App\Controller\Admin;

use App\Entity\Doctor;
use App\Form\DoctorType;
use App\Form\UserProfileType;
use App\Repository\DoctorRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Admin/doctorProfile")
 */
class DoctorProfileController extends AbstractController
{


    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="profile_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function index(UserRepository $userRepository, DoctorRepository $doctorRepository): Response

    {
        $user = $this->getUser();
//        $users= $doctorRepository->find($user);
        $doctor = $userRepository->find($user);
//        $doctor->getInfoDoctor();
        if (empty($doctor->getInfoDoctor())) {
            return $this->redirectToRoute('new_profile_doctor');
        }

        return $this->render('admin/doctorProfile/index.html.twig', [
            'users' => $doctor
        ]);
    }


    /**
     * @Route("/show/{id}", name="user_show", methods={"GET"})
     * @param $id
     * @param UserRepository $userRepository
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function show($id, UserRepository $userRepository, DoctorRepository $doctorRepository): Response
    {
        $user = $this->getUser();

//    dd($doctorProfile);
        $userProfile = $doctorRepository->findOneBy();
        return $this->render('admin/doctorProfile/show.html.twig', [
            'doctorProfile' => $userProfile,
        ]);
    }

    /**
     * @Route("/new",name="new_profile_doctor")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function new(Request $request)
    {

        $users = $this->getUser();
        $doctors = new Doctor();

        $doctors->setDoctorUser($users);

        $form = $this->createForm(DoctorType::class, $doctors);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('fichier')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                $doctors->setImage($newFilename);
                $this->manager->persist($doctors);
                $this->manager->flush();
                $this->addFlash('notice','the profile has been have successfully');
            } else {
                $this->manager->persist($doctors);
                $this->manager->flush();
                $this->addFlash('notice','the profile has been have successfully');

            }
            return $this->redirectToRoute('profile_index');

        }

        return $this->render('admin/doctorProfile/new.html.twig', ['form' => $form->createView(),
            'doctors' => $doctors,]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function edit($id, Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->flush();

            return $this->redirectToRoute('user_show');
        }

        return $this->render('admin/doctorProfile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }
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

