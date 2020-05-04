<?php

namespace App\Controller\Admin;

use App\Repository\MedicPrescriptionRepository;
use App\Repository\UserRepository;
use Artprima\QueryFilterBundle\QueryFilter\Config\BaseConfig;
use Artprima\QueryFilterBundle\QueryFilter\QueryFilter;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_PHARMACIST')")
 * @Route("Admin/pharmacist")
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
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(EntityManagerInterface $manager
        , MedicPrescriptionRepository $medicPrescriptionRepository,UserRepository $userRepository)
    {

        $this->manager = $manager;
        $this->medicPrescriptionRepository = $medicPrescriptionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("pharmacist_dashboard", name="pharmacist_dashboard" ,requirements={"page"="\d+"},defaults={"page"=1})
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard($page)
    {
//        $this->denyAccessUnlessGranted('ROLE_PHARMACIST', null, 'User tried to access a page without having ROLE_PHARMACIST');

        if ($page < 1) {
            throw $this->createNotFoundException('page."' . $page . '" does not exit');
        }
        $pharmacist=$this->getUser();
        $users=$this->userRepository->find($pharmacist);
        return $this->render('admin/pharmacist/dashboard.html.twig',
            ['users'=>$users]
            );
    }


    /**
     * @Route("see_prescriptions", name="see_prescriptions")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_PHARMACIST', null, 'User tried to access a page without having ROLE_PHARMACIST');


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
            $prescription= $this->medicPrescriptionRepository->find($id);
            return $this->render('admin/pharmacist/prescription/search.html.twig',['prescription'=>$prescription]);
        }
        return $this->render('admin/pharmacist/prescription/search.html.twig',['prescription'=>null]);
    }
}
