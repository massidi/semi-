<?php


namespace App\Event;


use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class UserSubscriber implements EventSubscriberInterface
{


    /**
     * @var SwiftmailerBundle
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;


    /**
     * UserSubscriber constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer,Environment $twig)
    {


        $this->mailer = $mailer;

        $this->twig = $twig;
    }


    public static function getSubscribedEvents()
    {
       return [
           UserRegisterEvent::Name =>'onUserRegister'
       ];
    }
    public function onUserRegister(UserRegisterEvent $event)
    {
        $body= $this->twig->render('email/registration.html.twig',[
            'user'=>$event->getRegisterUser()
        ]);
        $massage=(new \Swift_Message())
            ->setSubject('welcome to DMP application')
            ->setFormat('dph@gmail.com')
            ->setTo($event->getRegisterUser()->getEmail())
            ->setBody($body,'text/html');
        $this->mailer->send($massage);
    }
}