<?php


namespace App\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {


        $this->mailer = $mailer;

        $this->twig = $twig;
    }


    public static function getSubscribedEvents()
    {
        return [
            ContactEvent::Name => 'onNotification',
            UserRegisterEvent::Name => 'onUserRegister',
            MedicationEvent::Name => 'onMedicate',
        ];
    }

    public function onUserRegister(UserRegisterEvent $event)
    {

        $body = $this->twig->render('email/registration.html.twig', [
            'user' => $event->getRegisterUser(),
        ]);
        $massage = (new \Swift_Message())
            ->setSubject('welcome to DMP application')
            ->setFormat('dph@gmail.com')
            ->setTo($event->getRegisterUser()->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($massage);
    }

    public function onMedicate(MedicationEvent $event)
    {

        try {
            $body = $this->twig->render('email/medication.html.twig', [
                'medication' => $event->getMedicPrescription(),
            ]);
            $massage = (new \Swift_Message())
                ->setSubject('welcome to DMP application')
                ->setFormat('dph@gmail.com')
                ->setTo('semireddy@yahoo.fr')
                ->setBody($body, 'text/html');
            $this->mailer->send($massage);
        }
        catch (\Exception $e)
        {
            echo ($e);
        }
    }
    public function onNotification(ContactEvent $event)
    {
        try{
            $body= $this->twig->render('email/notification.html.twig',[
               'notification'=> $event->getContact()
            ]);
            $message= (new \Swift_Message('Hello '))
                ->setFrom('semi@gmil.com')
                ->setTo('Admin@gmial.com')
                ->setBody($body,'text/html');
            $this->mailer->send($message);

        }
        catch (\Exception $exception)
        {
            echo ($exception);

        }
    }
}