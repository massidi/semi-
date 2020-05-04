<?php

namespace App\Controller\Admin;

use App\Entity\MedicPrescription;
use App\Entity\User;
use App\Event\MedicationEvent;
use App\Form\MedicPrescriptionType;
use App\Repository\DoctorRepository;
use App\Repository\MedicPrescriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Tools\Pagination\LimitSubqueryOutputWalker;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

//use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Security("is_granted('ROLE_DOCTOR')")
 * @Route("/Admin/doctor")
 */
class DoctorController extends AbstractController
{

    /**
     *
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
    /**
     * @var DoctorRepository
     */
    private $doctorRepository;


    /**
     * DoctorController constructor.
     * @param EntityManagerInterface $manager
     * @param MedicPrescriptionRepository $medicPrescriptionRepository
     * @param UserRepository $userRepository
     * @param DoctorRepository $doctorRepository
     */
    public function __construct(EntityManagerInterface $manager
        , MedicPrescriptionRepository $medicPrescriptionRepository,UserRepository $userRepository,DoctorRepository $doctorRepository
    )
    {
        $this->manager = $manager;
        $this->medicPrescriptionRepository = $medicPrescriptionRepository;
        $this->userRepository = $userRepository;
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * @Route("/dashboard",name="doctor_dashboard",requirements={"page"="\d+"},defaults={"page"=1})
     * @param $page
     * @return Response
     */

    public function dashboard($page)
    {
        $this->denyAccessUnlessGranted('ROLE_DOCTOR', null, 'User tried to access a page without having ROLE_DOCTOR');


        if ($page < 1) {
            throw $this->createNotFoundException('page."' . $page . '" does not exit');
        }
        $doctor=$this->getUser();
        $users= $this->userRepository->find($doctor);
        return $this->render('admin/doctor/prescription/dashboard.html.twig',
            ['users'=>$users]);

    }

    /**
     * @Route("/doctor", name="doctor_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
//        $currentUser= $this->$tokenStorage->getToken()->getUser();
//        if ($currentUser instanceof User)
//        {
//        $hasAccess = $this->isGranted('ROLE_DOCTOR');

        $currentUser = $this->getUser();


        $prescriptions = $this->medicPrescriptionRepository->findByMedicName($currentUser,['createdAt'=>'ASC']

        );

        return $this->render('Admin/doctor/prescription/index.html.twig', [
            'prescriptions' => $prescriptions]);

    }

    /**
     * @Route("/doctorNew_prescrip",name="doctor_new")
     * @param Request $request
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function new(Request $request, EventDispatcherInterface $eventDispatcher)
    {
//        $doctor= $this->tokenStorage->getToken();
//        here are getting the current doctor who is connected
        $doctor = $this->getUser();

        $date = new \DateTime('now');
        $doctorPrescription = new MedicPrescription();
        $doctorPrescription->setCreatedAt($date);

        $doctorPrescription->setMedicName($doctor);


        $form = $this->createForm(MedicPrescriptionType::class, $doctorPrescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($doctorPrescription);
            $this->manager->flush();
            $medication = new MedicationEvent($doctorPrescription);
            $eventDispatcher->dispatch($medication, MedicationEvent::Name);

            return $this->redirectToRoute('doctor_index');

        }

        return $this->render('Admin/doctor/prescription/new.html.twig', ['form' => $form->createView(),
            'doctorPrescription' => $doctorPrescription,]);
    }


    /**
     * @Route("/show_doctor/{id}/",name="show_doctor")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {

        $prescription = $this->medicPrescriptionRepository->find($id);
        return $this->render("Admin/doctor/prescription/show.html.twig", [
            'prescription' => $prescription]);


    }

    /**
     * @Route("/edit/{id}", name="doctor_edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit($id, Request $request)
    {
        $medicPrescription = $this->medicPrescriptionRepository->find($id);
        $form = $this->createForm(MedicPrescriptionType::class, $medicPrescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            return $this->redirectToRoute('doctor_index');
        }

        return $this->render('Admin/doctor/prescription/edit.html.twig', [
            'medic_prescription' => $medicPrescription,
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("delete/{id}",name="prescription_delete")
     * @param Request $request
     * @param MedicPrescription $medicPrescription
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, MedicPrescription $medicPrescription, $id): Response
    {
        if ($this->isCsrfTokenValid('delete' . $medicPrescription->getId(), $request->request->get('_token'))) {

            $this->manager->remove($medicPrescription);
            $this->manager->flush();
        }


        return $this->redirectToRoute('doctor_index');
    }

    /**
     * @Route("/print/{id}",name="print_prescription")
     * @param $id
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function printPres($id, EventDispatcherInterface $eventDispatcher)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $prescription = $this->medicPrescriptionRepository->find($id);

        ///////here we are sending prescription to patient Email//////////

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Admin/doctor/prescription/print.html.twig', [
            'prescription' => $prescription
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("my prescription.pdf", [
            "Attachment" => false
        ]);
        $medication = new MedicationEvent($prescription);
        $eventDispatcher->dispatch($medication, MedicationEvent::Name);
    }


    /**
     * @Route("/latestrecord",name="latestrecord")
     */

    public function recordLatest()
    {

        $user = $this->getUser();

        $patient = $this->medicPrescriptionRepository->findByMedicName($user, ['id' => 'DESC'], 4, 0);


        return $this->render('admin/doctor/seelatest.html.twig',
            [
                'patient' => $patient,

            ]);


    }
}
