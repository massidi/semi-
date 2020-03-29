<?php

namespace App\Controller\profiles;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/{page}", name="home",requirements={"page"="\d+"},defaults={"page"=1})
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('page."' . $page . '" does not exit');
        }
        return $this->render('profiles/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
