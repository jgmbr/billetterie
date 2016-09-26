<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; 
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Validator\NotHolidays;
use AppBundle\Validator\NotTuesday;
use AppBundle\Validator\NotPreviousDay;
use AppBundle\Validator\NotAfterHours;
use AppBundle\Validator\NotMoreThousand;
use AppBundle\Validator\NotSunday;

/**
 * Booking
 *
 * @ORM\Table(name="app_booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
    /**
     * @var string
     *
     * @ORM\Column(name="code_booking", type="string", length=255)
     */
    private $codeBooking;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="date")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @NotHolidays()
	 * @NotTuesday()
     * @NotSunday()
	 * @NotMoreThousand()
	 * @NotPreviousDay()
     * @NotAfterHours()
     *
     * @ORM\Column(name="date_booking", type="date")
     */
    private $dateBooking;

    /**
     * @var string
     * @Assert\Email(
     *     message = "Email '{{ value }}' incorrect",
     *     checkMX = true
     * )
     * @Assert\NotBlank(message="Email incorrect")
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     * @Assert\Range(
     *      min = 1,
     *      max = 20,
     *      minMessage = "Vous devez commander au moins {{ limit }} billet",
     *      maxMessage = "Vous ne pouvez pas commander plus de {{ limit }} billets"
     * )
     * @Assert\Type(
     *     type="integer",
     *     message="Le nombre de billets entré doit être un chiffre."
     * )
     * @ORM\Column(name="total_quantity", type="integer")
     */
    private $totalQuantity;

    /**
     * @var float
     *
     * @ORM\Column(name="total_price", type="float", nullable=true)
     */
    private $totalPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;
	
    /**
     * @var bool
     * @Assert\Type(type="bool")
     *
     * @ORM\Column(name="state", type="boolean", options={"default":0})
     */
    private $state = false;
	
	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TicketType", cascade={"persist"})
     */
	private $ticketType;
	
	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="booking", cascade={"persist"})
	 */
	private $tickets;
	
	public function __construct($codeBooking)
	{ 
		$this->dateCreated 	= new \Datetime(); 
		$this->tickets 		= new ArrayCollection();
		$this->codeBooking	= $codeBooking;
	}

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Booking
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateBooking
     *
     * @param \DateTime $dateBooking
     *
     * @return Booking
     */
    public function setDateBooking($dateBooking)
    {
        $this->dateBooking = $dateBooking;

        return $this;
    }

    /**
     * Get dateBooking
     *
     * @return \DateTime
     */
    public function getDateBooking()
    {
        return $this->dateBooking;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set totalQuantity
     *
     * @param integer $totalQuantity
     *
     * @return Booking
     */
    public function setTotalQuantity($totalQuantity)
    {
        $this->totalQuantity = $totalQuantity;

        return $this;
    }

    /**
     * Get totalQuantity
     *
     * @return int
     */
    public function getTotalQuantity()
    {
        return $this->totalQuantity;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     *
     * @return Booking
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Booking
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set ticketType
     *
     * @param \AppBundle\Entity\TicketType $ticketType
     *
     * @return Booking
     */
    public function setTicketType(\AppBundle\Entity\TicketType $ticketType = null)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType
     *
     * @return \AppBundle\Entity\TicketType
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set codeBooking
     *
     * @param string $codeBooking
     *
     * @return Booking
     */
    public function setCodeBooking($codeBooking)
    {
        $this->codeBooking = $codeBooking;

        return $this;
    }

    /**
     * Get codeBooking
     *
     * @return string
     */
    public function getCodeBooking()
    {
        return $this->codeBooking;
    }

    /**
     * Set state
     *
     * @param boolean $state
     *
     * @return Booking
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }
}
