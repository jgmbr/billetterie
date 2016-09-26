<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table(name="app_contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 */
class Contact
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
     * @Assert\NotBlank(message="Nom invalide")
     * @Assert\Length(min="2", minMessage="Nom invalide : longueur minimale requise : {{ limit }}")
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Prénom invalide")
     * @Assert\Length(min="2", minMessage="Prénom invalide : longueur minimale requise : {{ limit }}")
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Email invalide")
     * @Assert\Length(min="2", minMessage="Email invalide : longueur minimale requise : {{ limit }}")
     * @Assert\Email(message="Adresse email invalide")
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Sujet invalide")
     * @Assert\Length(min="2", minMessage="Sujet invalide : longueur minimale requise : {{ limit }}")
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Message invalide")
     * @Assert\Length(min="5", minMessage="Message invalide : longueur minimale requise : {{ limit }}")
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Contact
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Contact
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
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
     * Set subject
     *
     * @param string $subject
     *
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
