<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index()
    {
        return $this->render('admin/patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }
}
