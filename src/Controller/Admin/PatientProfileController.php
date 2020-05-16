<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("Admin/patientProfile")
 * Class PatientProfileController
 * @package App\Controller\Admin
 */
class PatientProfileController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var PatientRepository
     */
    private $patientRepository;

    public function __construct(UserRepository $userRepository,EntityManagerInterface $manager,PatientRepository $patientRepository)
    {

        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $this->patientRepository = $patientRepository;
    }

    /**
     * @Route("/patientprofile", name="patient_profile")
     */
    public function index()
    {
        $user=$this->getUser();
        $patient_profile=$this->userRepository->find($user);
//       $users= $patient_profile->getInfoPatient();
//       dd($users->getAge());




        if (empty($patient_profile->getInfoPatient()))
        {
            return $this->redirectToRoute('new_profile_patient');
        }
        return $this->render('admin/patientProfile/index.html.twig', [
            'users' => $patient_profile,
        ]);
    }

    /**
     * @Route("/new",name="new_profile_patient")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $users = $this->getUser();
        $patientPrescription = new Patient();
        $patientPrescription->setPatientUser($users);
        $form = $this->createForm(PatientType::class, $patientPrescription);
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
                $patientPrescription->setImage($newFilename);
                $this->manager->persist($patientPrescription);
                $this->manager->flush();
                $this->addFlash('success', 'your profile has been updated successfully');

            } else {
                $this->manager->persist($patientPrescription);
                $this->manager->flush();
            }
            return $this->redirectToRoute('patient_profile');

        }


        return $this->render('admin/patientProfile/new.html.twig',
            ['form' => $form->createView(),
                'patientPrescription' => $patientPrescription

            ]);
    }

    /**
     * @Route("/{id}/edit",name="edit_pprofile")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit( Request $request ,$id)
    {
        $users= $this->getUser();
        $patient=$this->patientRepository->find($id);


        $form=$this->createForm(PatientType::class,$patient);
        $form->handleRequest($request);


        if ( $form->isSubmitted() && $form->isValid())
        {
            $this->manager->flush();
            $this->addFlash('success' ,'your profile has been updated successful');
            return $this->redirectToRoute('patient_profile');

        }
        return $this->render('admin/patientProfile/edit.html.twig',
            [   'form' => $form->createView(),
                'users' => $patient]
        );

    }
}
