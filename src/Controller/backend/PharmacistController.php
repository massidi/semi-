<?php

namespace App\Controller\backend;

use App\Entity\Pharmacist;
use App\Form\Pharmacist1Type;
use App\Repository\PharmacistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("backend/pharmacist")
 */
class PharmacistController extends AbstractController
{
    /**
     * @Route("/", name="pharmacist_index", methods={"GET"})
     * @param PharmacistRepository $pharmacistRepository
     * @return Response
     */
    public function index(PharmacistRepository $pharmacistRepository): Response
    {
        return $this->render('backend/pharmacist/index.html.twig', [
            'pharmacists' => $pharmacistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pharmacist_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $pharmacist = new Pharmacist();
        $form = $this->createForm(Pharmacist1Type::class, $pharmacist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pharmacist);
            $entityManager->flush();

            return $this->redirectToRoute('pharmacist_index');
        }

        return $this->render('backend/pharmacist/new.html.twig', [
            'pharmacist' => $pharmacist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pharmacist_show", methods={"GET"})
     * @param Pharmacist $pharmacist
     * @return Response
     */
    public function show(Pharmacist $pharmacist): Response
    {
        return $this->render('backend/pharmacist/show.html.twig', [
            'pharmacist' => $pharmacist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pharmacist_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Pharmacist $pharmacist
     * @return Response
     */
    public function edit(Request $request, Pharmacist $pharmacist): Response
    {
        $form = $this->createForm(Pharmacist1Type::class, $pharmacist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pharmacist_index');
        }

        return $this->render('backend/pharmacist/edit.html.twig', [
            'pharmacist' => $pharmacist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pharmacist_delete", methods={"DELETE"})
     * @param Request $request
     * @param Pharmacist $pharmacist
     * @return Response
     */
    public function delete(Request $request, Pharmacist $pharmacist): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pharmacist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pharmacist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pharmacist_index');
    }
}
