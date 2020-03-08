<?php

namespace App\Controller\Admin;

use App\Entity\Doctor;
use App\Entity\MedicPrescription;
use App\Entity\Patient;
use App\Form\DoctorType;
use App\Repository\DoctorRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Admin")
 */

class DoctorController extends AbstractController
{
    /**
     * @var DoctorRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var PatientRepository
     */
    private $patientRepository;

    public  function __construct(DoctorRepository $repository,EntityManagerInterface $manager,PatientRepository $patientRepository)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->patientRepository = $patientRepository;
    }


    /**
     * @Route("/doctor", name="doctor_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
       $doctors=$this->repository->findAll();
        return $this->render('Admin/doctor/index.html.twig', [
            'doctor' => $doctors,
        ]);
    }

    /**
     * @Route("/doctor_new",name="doctor_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $doctor=  new Doctor();
        $form=$this->createForm(DoctorType::class,$doctor);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {
            $this->manager->persist($doctor);
            $this->manager->flush();
            $this->addFlash('success','save');
            return $this->redirectToRoute('doctor_index');


        }
        return $this->render('Admin/doctor/new.html.twig',['form'=>$form->createView(),
            'doctors'=>$doctor,]);

    }

    /**
     * @Route("/show_doctor/{id}/",name="show_doctor")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
       $doctors=$this->repository->find($id);
       return $this->render("Admin/doctor/show.html.twig",[
           'doctor'=>$doctors
       ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit($id,Request $request)
    {
        $doctors=$this->repository->find($id);
        $form=$this->createForm(DoctorType::class, $doctors);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->manager->flush();
            $this->addFlash();
            return $this->redirectToRoute('doctor_index');
        }

         $doctors=$this->repository->findAll();
        return $this->render('Admin/doctor/edit.html.twig',['form'=>$form->createView(),
            'doctors'=>$doctors,
        ]);


    }

    /**
     * @Route("delete/{id}",name="delete")
     * @param $id
     * @param Request $
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public  function delete($id,Request $request)
    {
        $doctors= $this->repository->find($id);
        if($this->isCsrfTokenValid('delete'.$doctors->getId(),$request->get('_token')))
        {
            $this->em->remove($doctors);
            $this->em->flush();
            $this->addFlash('success','edited');
            // return new Response('Suppression');
        }
        return $this->redirectToRoute('doctor_index');

    }

    /**
     * @Route("patientlatest",name="patient_latest")
     */

    public  function  patientLatest()
    {
        $patientRepository=$this->patientRepository->findLatest();

        return $this->render('admin/doctor/seelatest.html.twig');


    }
}
