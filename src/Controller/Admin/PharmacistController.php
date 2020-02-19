<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PharmacistController extends AbstractController
{
    /**
     * @Route("/pharmacist", name="pharmacist")
     */
    public function index()
    {
        return $this->render('Admin/pharmacist/index.html.twig', [
            'controller_name' => 'PharmacistController',
        ]);
    }
}
