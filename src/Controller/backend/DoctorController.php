<?php

namespace App\Controller\backend;

use App\Entity\Doctor;
use App\Form\Doctor1Type;
use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("backend/doctor")
 */
class DoctorController extends AbstractController
{
    /**
     * @Route("/", name="doctor_index_backend", methods={"GET"})
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function index(DoctorRepository $doctorRepository): Response
    {
        return $this->render('backend/doctor/index.html.twig', [
            'doctors' => $doctorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="doctor_new_backend", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $doctor = new Doctor();
        $form = $this->createForm(Doctor1Type::class, $doctor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($doctor);
            $entityManager->flush();

            return $this->redirectToRoute('doctor_index');
        }

        return $this->render('backend/doctor/new.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="doctor_show_backend", methods={"GET"})
     * @param Doctor $doctor
     * @return Response
     */
    public function show(Doctor $doctor): Response
    {
        return $this->render('backend/doctor/show.html.twig', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="doctor_edit_backend", methods={"GET","POST"})
     * @param Request $request
     * @param Doctor $doctor
     * @return Response
     */
    public function edit(Request $request, Doctor $doctor): Response
    {
        $form = $this->createForm(Doctor1Type::class, $doctor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('doctor_index');
        }

        return $this->render('backend/doctor/edit.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="doctor_delete_backend", methods={"DELETE"})
     * @param Request $request
     * @param Doctor $doctor
     * @return Response
     */
    public function delete(Request $request, Doctor $doctor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$doctor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($doctor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('doctor_index');
    }
}
