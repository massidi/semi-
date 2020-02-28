<?php

namespace App\Controller\Admin;

use App\Entity\MedicPrescription;
use App\Form\MedicPrescriptionType;
use App\Repository\MedicPrescriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/Admin")
 */
class MedicPrescriptionController extends AbstractController
{
    /**
     * @var MedicPrescriptionRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(MedicPrescriptionRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/medic_prescription_index", name="medic_prescription_index", methods={"GET"})
     * @param MedicPrescriptionRepository $medicPrescriptionRepository
     * @return Response
     */
    public function index(MedicPrescriptionRepository $medicPrescriptionRepository): Response
    {
        return $this->render('Admin/medic_prescription/index.html.twig', [
            'medic_prescriptions' => $medicPrescriptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/medic_prescription_new", name="medic_prescription_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $medicPrescription = new MedicPrescription();


        $form = $this->createForm(MedicPrescriptionType::class, $medicPrescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medicPrescription);
            $entityManager->flush();

            return $this->redirectToRoute('medic_prescription_index');
        }

        return $this->render('Admin/medic_prescription/new.html.twig', [
            'medic_prescription' => $medicPrescription,
            'form' => $form->createView(),
        ]);
    }

/*
    /**
     * @Route("/show/{id}", name="medic_prescription_show")
     * @param Request $request
     * @return Response
     */
/*
   public function show(Request $request): Response
    {
        $medicPrescription= new MedicPrescription();

        $medicPrescription->getDrug();


        $this->manager->persist($medicPrescription);
        $this->manager->flush();




        return $this->render('medic_prescription/show.html.twig', [
            'medic_prescription' => $medicPrescription,
        ]);
    }
*/
    /**
     * @Route("/{id}/edit", name="medic_prescription_edit", methods={"GET","POST"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function edit(Request $request,$id): Response
    {
        $medicPrescription=$this->repository->find($id);
        $form = $this->createForm(MedicPrescriptionType::class, $medicPrescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            return $this->redirectToRoute('medic_prescription_index');
        }

        return $this->render('Admin/medic_prescription/edit.html.twig', [
            'medic_prescription' => $medicPrescription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/medic_prescription_delete/{id}", name="medic_prescription_delete", methods={"DELETE"})
     * @param Request $request
     * @param MedicPrescription $medicPrescription
     * @return Response
     */
    public function delete(Request $request, MedicPrescription $medicPrescription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicPrescription->getId(), $request->request->get('_token'))) {

            $this->manager->remove($medicPrescription);
            $this->manager->flush();
        }

        return $this->redirectToRoute('medic_prescription_index');
    }
}
