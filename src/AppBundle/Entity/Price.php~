<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; 
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * Price
 *
 * @ORM\Table(name="app_price")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceRepository")
 */
class Price
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
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(name="age_min", type="integer")
     */
    private $ageMin;

    /**
     * @var int
     *
     * @ORM\Column(name="age_max", type="integer")
     */
    private $ageMax;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="string", length=255)
     */
    private $conditions;

    /**
     * @var string
     *
     * @ORM\Column(name="name_fr", type="string", length=255)
     */
    private $nameFr;
	
    /**
     * @var string
     *
     * @ORM\Column(name="slug_fr", type="string", length=255)
     */
    private $slugFr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=255)
     */
    private $nameEn;

    /**
     * @var string
     *
     * @ORM\Column(name="slug_en", type="string", length=255)
     */
    private $slugEn;
	
    /**
     * @var string
     *
     * @ORM\Column(name="infos_fr", type="string", length=255, nullable=true)
     */
    private $infosFr;

    /**
     * @var string
     *
     * @ORM\Column(name="infos_en", type="string", length=255, nullable=true)
     */
    private $infosEn;


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
     * Set code
     *
     * @param string $code
     *
     * @return Price
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set ageMin
     *
     * @param integer $ageMin
     *
     * @return Price
     */
    public function setAgeMin($ageMin)
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    /**
     * Get ageMin
     *
     * @return int
     */
    public function getAgeMin()
    {
        return $this->ageMin;
    }

    /**
     * Set ageMax
     *
     * @param integer $ageMax
     *
     * @return Price
     */
    public function setAgeMax($ageMax)
    {
        $this->ageMax = $ageMax;

        return $this;
    }

    /**
     * Get ageMax
     *
     * @return int
     */
    public function getAgeMax()
    {
        return $this->ageMax;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return Price
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

    /**
     * Set nameFr
     *
     * @param string $nameFr
     *
     * @return Price
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
     * @return Price
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
     * Set slugFr
     *
     * @param string $slugFr
     *
     * @return Price
     */
    public function setSlugFr($slugFr)
    {
        $this->slugFr = $slugFr;

        return $this;
    }

    /**
     * Get slugFr
     *
     * @return string
     */
    public function getSlugFr()
    {
        return $this->slugFr;
    }

    /**
     * Set slugEn
     *
     * @param string $slugEn
     *
     * @return Price
     */
    public function setSlugEn($slugEn)
    {
        $this->slugEn = $slugEn;

        return $this;
    }

    /**
     * Get slugEn
     *
     * @return string
     */
    public function getSlugEn()
    {
        return $this->slugEn;
    }

    /**
     * Set infosFr
     *
     * @param string $infosFr
     *
     * @return Price
     */
    public function setInfosFr($infosFr)
    {
        $this->infosFr = $infosFr;

        return $this;
    }

    /**
     * Get infosFr
     *
     * @return string
     */
    public function getInfosFr()
    {
        return $this->infosFr;
    }

    /**
     * Set infosEn
     *
     * @param string $infosEn
     *
     * @return Price
     */
    public function setInfosEn($infosEn)
    {
        $this->infosEn = $infosEn;

        return $this;
    }

    /**
     * Get infosEn
     *
     * @return string
     */
    public function getInfosEn()
    {
        return $this->infosEn;
    }
}
