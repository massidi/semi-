<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PharmacistController extends AbstractController
{
    /**
     * @Route("/pharmacist", name="pharmacist")
     */
    public function index()
    {
        return $this->render('admin/pharmacist/index.html.twig', [
            'controller_name' => 'PharmacistController',
        ]);
    }
}
