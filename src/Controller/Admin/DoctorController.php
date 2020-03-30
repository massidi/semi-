<?php

namespace App\Controller\Admin;

use App\Entity\MedicPrescription;
use App\Entity\User;
use App\Event\MedicationEvent;
use App\Form\MedicPrescriptionType;
use App\Repository\MedicPrescriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 *
 * @Route("/Admin")
 */

class DoctorController extends AbstractController
{

    /**
     *
     */
    private $manager;

    /**
     * @var MedicPrescriptionRepository
     */
    private $medicPrescriptionRepository;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;


    /**
     * DoctorController constructor.
     * @param EntityManagerInterface $manager
     * @param MedicPrescriptionRepository $medicPrescriptionRepository
     */
    public  function __construct(EntityManagerInterface $manager
    , MedicPrescriptionRepository $medicPrescriptionRepository
    )
    {
        $this->manager = $manager;
        $this->medicPrescriptionRepository = $medicPrescriptionRepository;
    }


    /**
     * @Route("/doctor", name="doctor_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
//        $currentUser= $this->$tokenStorage->getToken()->getUser();
//        if ($currentUser instanceof User)
//        {
//        $hasAccess = $this->isGranted('ROLE_DOCTOR');


        $currentUser= $this->getUser();

            $prescriptions= $this->medicPrescriptionRepository->findAllByUsers($currentUser);

            return $this->render('Admin/doctor/prescription/index.html.twig',[
                'prescriptions'=>$prescriptions]);


//        }
//        throw new \RuntimeException('I don\'t have a token');


    }

    /**
     * @Route("/doctorNew_prescrip",name="doctor_new")
     * @param Request $request
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new1(Request $request,EventDispatcherInterface $eventDispatcher)
    {
//        $doctor= $this->tokenStorage->getToken();
        $doctor= $this->getUser();


        $doctorPrescription = new MedicPrescription();
        $doctorPrescription->setMedicName($doctor);

        $form = $this->createForm(MedicPrescriptionType::class, $doctorPrescription );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($doctorPrescription);
            $entityManager->flush();
            $medication=new MedicationEvent($doctorPrescription);
            $eventDispatcher->dispatch($medication,MedicationEvent::Name);

            return $this->redirectToRoute('doctor_index');

        }

        return $this->render('Admin/doctor/prescription/new.html.twig',['form'=>$form->createView(),
            'doctorPrescription'=>$doctorPrescription,]);
        }


    /**
     * @Route("/show_doctor/{id}/",name="show_doctor")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
       $doctors=$this->medicPrescriptionRepository->find($id);
       return $this->render("Admin/doctor/prescription/show.html.twig",[
           'doctor'=>$doctors
       ]);
    }

    /**
     * @Route("/edit/{id}", name="doctor_edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit($id,Request $request)
    {
        $medicPrescription=$this->medicPrescriptionRepository->find($id);
        $form = $this->createForm(MedicPrescriptionType::class, $medicPrescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $this->manager->flush();

            return $this->redirectToRoute('doctor_index');
        }

        return $this->render('Admin/doctor/prescription/edit.html.twig', [
            'medic_prescription' => $medicPrescription,
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("delete/{id}",name="doctor_delete")
     * @param Request $request
     * @param MedicPrescription $medicPrescription
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, MedicPrescription $medicPrescription,$id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicPrescription->getId(), $request->request->get('_token'))) {

            $this->manager->remove($medicPrescription);
            $this->manager->flush();
        }


        return $this->redirectToRoute('doctor_index');
    }


//    /**
//     * @Route("/patientlatest",name="patient_latest")
//     */
//
//    public  function  patientLatest()
//    {
//        $patient=$this->patientRepository->findLatest();
//        $prescription=$this->medicPrescriptionRepository->findLatestprescript();
//
//
//
//        return $this->render('admin/doctor/seelatest.html.twig',
//            [
//                'patient'=>$patient,
//                'prescription'=>$prescription,
//            ]);
//
//
//    }
//    /**
//     * @Route("/prescriptlatest",name="prescript_latest")
//     *
//     */
/*
    public  function  prescriptLatest()
    {
        $prescription=$this->medicPrescriptionRepository->findLatestprescript();


        return $this->render('admin/doctor/seelatest.html.twig',
            [
                'prescription'=>$prescription,
            ]);


    }*/

}
