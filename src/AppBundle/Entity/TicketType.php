<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; 
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * TicketType
 *
 * @ORM\Table(name="app_ticket_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketTypeRepository")
 */
class TicketType
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
     * @ORM\Column(name="name_fr", type="string", length=255)
     */
    private $nameFr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=255)
     */
    private $nameEn;

    /**
     * @var float
     *
     * @ORM\Column(name="impact", type="float")
     */
    private $impact;
	
    /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="string", length=255, nullable=true)
     */
    private $conditions;


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
     * Set nameFr
     *
     * @param string $nameFr
     *
     * @return TicketType
     */
    public function setNameFr($nameFr)
    {
        $this->nameFr = $nameFr;

        return $this;
    }

    /**
     * Get nameFr
     *
     * @return string
     */
    public function getNameFr()
    {
        return $this->nameFr;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return TicketType
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * Set impact
     *
     * @param float $impact
     *
     * @return TicketType
     */
    public function setImpact($impact)
    {
        $this->impact = $impact;

        return $this;
    }

    /**
     * Get impact
     *
     * @return float
     */
    public function getImpact()
    {
        return $this->impact;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return TicketType
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }
}
