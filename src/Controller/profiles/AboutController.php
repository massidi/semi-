<?php

namespace App\Controller\profiles;

use App\Entity\AboutUs;
use App\Form\AboutUsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function index()
    {
        return $this->render('profiles/about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
    public function new(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $aboutus = new AboutUs();
        $form = $this->createForm(AboutUsType::class, $aboutus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aboutus);
            $entityManager->flush();

            return $this->redirectToRoute('about');
        }

        return $this->render('profiles/about/new.html.twig', [
            'aboutus' => $aboutus,
            'form' => $form->createView(),
        ]);
    }
}
