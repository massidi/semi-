<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use App\Repository\MedicPrescriptionRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PatientController
 * @Route("/Admin/patient1")
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
     * @var AppointmentRepository
     */
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository, MedicPrescriptionRepository $prescriptionRepository, EntityManagerInterface $manager)
    {

        $this->manager = $manager;
        $this->prescriptionRepository = $prescriptionRepository;
        $this->appointmentRepository = $appointmentRepository;
    }

    /**
     * @Route("/patient", name="patient_index")
     */
    public function index()
    {
        return $this->render('Admin/patient/prescription/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }


    /**
     * @Route("/patient_prescrip/{id}",name="patient_prescription")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prescription($id)
    {
        $patientPrescription = $this->prescriptionRepository->find($id);
        return $this->render('admin/patient/prescription/patientPrescrip.html.twig', [
            'patientPrescription' => $patientPrescription
        ]);

    }

    /**
     * @Route("/new_appointment",name="create_appoitment")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
       $appointment = new Appointment();
        $form= $this->createForm(AppointmentType::class,$appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appointment);
            $entityManager->flush();

            return $this->redirectToRoute('patient_index');
        }



        return $this->render('admin/patient/appointment/createApp.html.twig', []);
    }

    /**
     * @Route("/edit_app/{id}",name="edit_appoitment")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit($id,Request $request)
    {
        $appointment= $this->appointmentRepository->find($id);
        $form= $this->createForm(AppointmentType::class,$appointment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appointment);
            $entityManager->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('admin/patient/appointment/editApp.html.twig', []);
    }

    /**
     * @Route("/show_app",name="show_appoitment")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $appointment= $this->appointmentRepository->find($id);

        return $this->render('admin/patient/appointment/createApp.html.twig',[
            'appointment'=>$appointment,
        ]);
    }

    /**
     * @Route("/new_app",name="create_appoitment")
     * @param Request $request
     * @param $id
     * @param Appointment $appointment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request,$id,Appointment $appointment)
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {

            $this->manager->remove($appointment);
            $this->manager->flush();
        }


        return $this->redirectToRoute('patient_index');

    }
}