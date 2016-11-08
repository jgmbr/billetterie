<?php

namespace AppBundle\Services\Booking;

use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;

class Prices
{
    private $em;

    private $servicePrice;

    private $serviceAge;

    private $total;

    public function __construct(EntityManagerInterface $em, \AppBundle\Services\Ticket\Price $servicePrice, \AppBundle\Services\Ticket\Age $serviceAge)
    {
        $this->em = $em;

        $this->servicePrice = $servicePrice;

        $this->serviceAge = $serviceAge;

        $this->total = 0;
    }

    public function setTotalPrices(Booking $currentBooking)
    {
        foreach($currentBooking->getTickets() as $ticket)
        {
            $condition = "age";
            if($ticket->getReduction())
                $condition = "reduction";

            $objPrice = $this->servicePrice->getPrice($this->serviceAge->getAge($ticket->getBirthday()), $condition);

            $price = $objPrice->getPrice() * $currentBooking->getTicketType()->getImpact();

            $this->total += $price;

            $ticket->setPrice($objPrice);

            $ticket->setBooking($currentBooking);

            $this->em->persist($ticket);
        }

        $currentBooking->setTotalPrice((float)$this->total);

        return $currentBooking;
    }
}