<?php

namespace App\Controller\Admin;

use App\Repository\MedicPrescriptionRepository;
use Artprima\QueryFilterBundle\QueryFilter\Config\BaseConfig;
use Artprima\QueryFilterBundle\QueryFilter\QueryFilter;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("Admin/")
 * Class PharmacistController
 * @package App\Controller\Admin
 */
class PharmacistController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var MedicPrescriptionRepository
     */
    private $medicPrescriptionRepository;

    public function __construct(EntityManagerInterface $manager
        , MedicPrescriptionRepository $medicPrescriptionRepository)
    {

        $this->manager = $manager;
        $this->medicPrescriptionRepository = $medicPrescriptionRepository;
    }

    /**
     * @Route("pharmacist_dashboard", name="pharmacist_dashboard" ,requirements={"page"="\d+"},defaults={"page"=1})
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard($page)
    {

        if ($page < 1) {
            throw $this->createNotFoundException('page."' . $page . '" does not exit');
        }
        return $this->render('admin/pharmacist/dashboard.html.twig');
    }


    /**
     * @Route("see_prescriptions", name="see_prescriptions")
     */
    public function index()
    {

        $currentUser = $this->getUser();

        $prescriptions= $this->medicPrescriptionRepository->finAll($currentUser);

        return $this->render('admin/pharmacist/prescription/index.html.twig', [
            'prescriptions' => '$prescriptions',
        ]);
    }

    /**
     * @Route("search_prescription",name="search_prescription")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public  function  searchPrescription(Request $request)
    {

        if ($request->isMethod("POST"))
        {
            $id = $request->request->get('id');
            $search= $this->manager->getRepository($this->medicPrescriptionRepository->find($id));
            return $this->render('admin/pharmacist/prescription/search.html.twig',['search'=>$search]);
        }
        return $this->render('admin/pharmacist/prescription/search.html.twig',['search'=>null]);

    }
}
