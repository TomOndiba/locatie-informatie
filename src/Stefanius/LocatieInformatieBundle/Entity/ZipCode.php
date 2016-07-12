<?php

namespace Stefanius\LocatieInformatieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZipCode
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ZipCode extends Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pnum", type="smallint")
     */
    private $pnum;

    /**
     * @var string
     *
     * @ORM\Column(name="pchar", type="string", length=2)
     */
    private $pchar;

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
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=254)
     */
    private $street;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="City", inversedBy="zipCodes")
     */
    protected $city;

    function __construct()
    {
        $this->locationType = "zipcode";
    }

    public function setTitle($title)
    {
        $title = trim($title);
        $title = str_replace(' ', '', $title);

        $this->pnum = (int)substr($title, 0, 4);
        $this->pchar = substr($title, 4, 2);

        $this->title = $title;

        return $this;
    }

    /**
     * @return int
     */
    public function getPnum()
    {
        return $this->pnum;
    }

    /**
     * @return string
     */
    public function getPchar()
    {
        return $this->pchar;
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
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
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
}
