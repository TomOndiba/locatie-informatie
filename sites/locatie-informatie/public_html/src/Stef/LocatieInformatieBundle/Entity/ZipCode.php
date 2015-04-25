<?php

namespace Stef\LocatieInformatieBundle\Entity;

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
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=6)
     */
    private $postcode;

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
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="province_code", type="string", length=3)
     */
    private $provinceCode;

    function __construct()
    {
        $this->locationType = "zipcode";
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $postcode = trim($postcode);
        $postcode = str_replace(' ', '', $postcode);

        $this->pnum = (int)substr($postcode, 0, 4);
        $this->pchar = substr($postcode, 3, 2);

        $this->postcode = $postcode;
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
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getProvinceCode()
    {
        return $this->provinceCode;
    }

    /**
     * @param string $provinceCode
     */
    public function setProvinceCode($provinceCode)
    {
        $this->provinceCode = $provinceCode;
    }
}
