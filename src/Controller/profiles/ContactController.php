<?php

namespace App\Controller\profiles;

use App\Entity\Contact;
use App\Event\ContactEvent;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
{
    $this->manager = $manager;
}

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request,EventDispatcherInterface $eventDispatcher)
    {
        $contacts= new Contact();
        $form=$this->createForm(ContactType::class ,$contacts);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->manager->persist($contacts);
            $this->manager->flush();
            $this->addFlash('success','Email sent thank you');

            //////sending a notification///////

            $notification= new ContactEvent($contacts);
            $eventDispatcher->dispatch($notification,ContactEvent::Name);
            return $this->redirectToRoute('home');


        }
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
