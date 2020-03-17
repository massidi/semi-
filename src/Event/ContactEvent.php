<?php


namespace App\Event;


use App\Entity\Contact;
use Symfony\Contracts\EventDispatcher\Event;

class ContactEvent extends  Event
{
      const Name ='notification.contact';
    /**
     * @var Contact
     */
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return Contact
     */
    public function getContact():Contact
    {
        return $this->contact;
    }

}