<?php

namespace App\Controller\Admin;


use App\Entity\MedicPrescription;

;

use App\Repository\MedicPrescriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PatientController
 * @Route("/Admin/patient")
 * @package App\Controller\Admin
 *
 */
class PatientController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var MedicPrescriptionRepository
     */
    private $prescriptionRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(MedicPrescriptionRepository $prescriptionRepository, EntityManagerInterface $manager,UserRepository $userRepository)
    {

        $this->manager = $manager;
        $this->prescriptionRepository = $prescriptionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/dashboard",name="patient_dashboard",requirements={"page"="\d+"},defaults={"page"=1})
     */

    public  function  dashboard($page)
    {
        $this->denyAccessUnlessGranted('ROLE_PATIENT', null, 'User tried to access a page without having ROLE_PATIENT');

        if ($page < 1)
        {
            throw  $this->createNotFoundException('page."' . $page . '" does not exit');
        }
        $patient=$this->getUser();
        $fourPrescription = $this->prescriptionRepository->findByPatientName($patient, ['id' => 'DESC'], 3, 0);
        $users= $this->userRepository->find($patient);
        return $this->render('admin/patient/dashboard.html.twig',
            ['users'=>$users,
                'patient'=>$fourPrescription]
        );

    }


    /**
     * @Route("/", name="patient_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        ///////////////////here the patient will see all his medical prescriptions written by the doctor/////////
        /// ///////////////by calling the function getPatientName using the relation one to many from the inverse side/////
        /// ////////////// from the owning side(User entity) we have a private variable patientPrescription///////////
        $patient = $this->getUser();
        $PatientPrescription = $this->prescriptionRepository->findByPatientName($patient);

        dd($PatientPrescription);

        return $this->render('Admin/patient/prescription/index.html.twig', [
            'PatientPrescription' => $PatientPrescription,
        ]);
    }


    /**
     * @Route("/show",name="show_prescription")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        /////////////////over her the patient will display one prescription at the time with ///////////
        /// ///////////// all the details//////////////////////////////////////////////////////////////
        $patientPrescription = $this->prescriptionRepository->find($id);

        return $this->render('admin/patient/prescription/show.html.twig', [
            'patientPrescription' => $patientPrescription,
        ]);
    }

    /**
     * @Route("/seelastprescription",name="fourLastPrescription")
     */
    public function seeLastPrescription()
    {
        ///////////////////here we patient gonna see the early last four prescriptions////////
        $prescription = $this->getUser();
        $fourPrescription = $this->prescriptionRepository->findByPatientName($prescription, ['id' => 'DESC'], 4, 0);
        return $this->render('admin/patient/prescription/seeLastPrescription.html.twig', [
            'fourPrescription' => $fourPrescription
        ]);

    }



    /**
     * @Route("/delete/{id}",name="delete_prescription")
     * @param Request $request
     * @param MedicPrescription $prescription
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, MedicPrescription $prescription, $id)
    {
        ///////////////over here we have the delete method which will delete one item////////////
        /// ///////////we need to inject the concern entity as argument in delete function //////
        if ($this->isCsrfTokenValid('delete' . $prescription->getId(), $request->request->get('_token'))) {

            //////here we are using the object manager of the entityManagerInterface class //////////
            /////to call remove function the item will be removed from the data base
            $this->manager->remove($prescription);
            $this->manager->flush();
        }


        return $this->redirectToRoute('prescription_index');

    }
    /**
     * @Route("/patient_calendar",name="pcalendar")
     */
    public function  calendar()
    {
        return $this->render('admin/patient/calendar.html.twig');

    }
}