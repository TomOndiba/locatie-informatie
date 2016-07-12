<?php

namespace Stef\LocatieInformatieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ZipCode
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Street extends Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="minnumber", type="integer")
     */
    private $minnumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxnumber", type="integer")
     */
    private $maxnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="numbertype", type="string", length=10)
     */
    private $numbertype;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ZipCode", mappedBy="street")
     */
    protected $zipCodes;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="City", inversedBy="zipCodes")
     */
    protected $city;

    function __construct()
    {
        $this->locationType = "street";
        $this->zipCodes = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getMinnumber()
    {
        return $this->minnumber;
    }

    /**
     * @param int $minnumber
     */
    public function setMinnumber($minnumber)
    {
        $this->minnumber = $minnumber;
    }

    /**
     * @return int
     */
    public function getMaxnumber()
    {
        return $this->maxnumber;
    }

    /**
     * @param int $maxnumber
     */
    public function setMaxnumber($maxnumber)
    {
        $this->maxnumber = $maxnumber;
    }

    /**
     * @return string
     */
    public function getNumbertype()
    {
        return $this->numbertype;
    }

    /**
     * @param string $numbertype
     */
    public function setNumbertype($numbertype)
    {
        $this->numbertype = $numbertype;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return ArrayCollection
     */
    public function getZipCodes()
    {
        return $this->zipCodes;
    }

    /**
     * @param ArrayCollection $zipCodes
     */
    public function setZipCodes($zipCodes)
    {
        $this->zipCodes = $zipCodes;
    }

    /**
     * @param ZipCode $zipCode
     */
    public function addZipCode(ZipCode $zipCode)
    {
        $this->zipCodes->add($zipCode);
    }
}
