<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(UserRepository $userRepository,EntityManagerInterface $manager)
    {

        $this->userRepository = $userRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("/patientprofile", name="patient_profile")
     */
    public function index()
    {
        $users=$this->getUser();
        $patient=$this->userRepository->find($users);

        if (empty($patient->getInfoPatient()))
        {
            return $this->redirectToRoute('new_profile');
        }
        return $this->render('admin/patientProfile/index.html.twig', [
            'controller_name' => 'PatientProfileController',
        ]);
    }

    /**
     * @Route("/new",name="new_profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $users=$this->getUser();
        $patientPrescription= new Patient();
        $patientPrescription->setPatientUser($users);
        $form=$this->createForm(PatientType::class,$patientPrescription);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->manager->persist($patientPrescription);
            $this->addFlash('success','your profile has been updated successfully');
            $this->manager->flush();

            return $this->redirectToRoute('patient_profile');
        }
        return $this->render('admin/patientProfile/new.html.twig',
        ['form'=> $form->createView(),
            'patientPrescription'=>$patientPrescription

        ]);
    }
}
