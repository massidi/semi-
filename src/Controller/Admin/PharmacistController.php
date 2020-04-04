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
     * @Route("/dashboard", name="pharmacist_dashboard" ,requirements={"page"="\d+"},defaults={"page"=1})
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
     * @Route("/see_prescriptions", name="see_prescriptions")
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
     * @Route("/search_prescription",name="search_prescription")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public  function  searchPrescription(Request $request, $id)
    {

        $search= $this->manager->getRepository($this->medicPrescriptionRepository->find($id));
        if ($request->isMethod("POST"))
        {
            $prescription= $request->get('prescription');
            $search= $this->manager->getRepository($this->medicPrescriptionRepository->findBy(['prescription'=>$prescription]));
            return $this->redirectToRoute('show_doctor');

        }
//        // set up the config
//        $config = new BaseConfig();
//        $config->setSearchAllowedCols(['t.name']);
//        $config->setAllowedLimits([10, 25, 50, 100]);
//        $config->setDefaultLimit(1);
//        $config->setSortCols(['t.id'], ['t.id' => 'asc']);
//        $config->setRequest(new Request($request));
//
//        // here we provide a repository callback that will be used internally in the QueryFilter
//        // The signature of the method must be as follows: function functionName(QueryFilterArgs $args): QueryResult;
//        $config->setRepositoryCallback([$prescription, 'findByOrderBy']);
//
//        // Response must implement Artprima\QueryFilterBundle\Response\ResponseInterface
//        $queryFilter = new QueryFilter(Response::class);
//        /** @var Response $data the type of the variable is defined by the class in the first argument of QueryFilter's constructor */
//        $response = $queryFilter->getData($config);
//        $data = $response->getData();
//        $meta = $response->getMeta();

        // ... now do something with $data or $meta

        return $this->render('admin/pharmacist/prescription/search.html.twig',['search'=>$search]);


    }
}
