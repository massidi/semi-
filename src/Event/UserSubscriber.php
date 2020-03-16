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
            UserRegisterEvent::Name => 'onUserRegister',
            MedicationEvent::Name => 'onMedicate'
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
}