<?php

namespace Stef\LocatieInformatieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postcode: Based on orignal postcode DB. Not further used in application.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Postcode
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=7)
     */
    private $postcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="postcode_id", type="integer")
     */
    private $postcodeId;

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
     * @var integer
     *
     * @ORM\Column(name="city_id", type="integer")
     */
    private $cityId;

    /**
     * @var string
     *
     * @ORM\Column(name="municipality", type="string", length=100)
     */
    private $municipality;

    /**
     * @var integer
     *
     * @ORM\Column(name="municipality_id", type="integer")
     */
    private $municipalityId;

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255)
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="province_code", type="string", length=3)
     */
    private $provinceCode;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="decimal")
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lon", type="decimal", precision=15, scale=13)
     */
    private $lon;

    /**
     * @var string
     *
     * @ORM\Column(name="rd_x", type="decimal", precision=15, scale=13)
     */
    private $rdX;

    /**
     * @var string
     *
     * @ORM\Column(name="rd_y", type="decimal")
     */
    private $rdY;

    /**
     * @var string
     *
     * @ORM\Column(name="location_detail", type="string", length=10)
     */
    private $locationDetail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changed_date", type="datetime")
     */
    private $changedDate;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set postcodeId
     *
     * @param integer $postcodeId
     * @return Postcode
     */
    public function setPostcodeId($postcodeId)
    {
        $this->postcodeId = $postcodeId;

        return $this;
    }

    /**
     * Get postcodeId
     *
     * @return integer 
     */
    public function getPostcodeId()
    {
        return $this->postcodeId;
    }

    /**
     * Set pnum
     *
     * @param integer $pnum
     * @return Postcode
     */
    public function setPnum($pnum)
    {
        $this->pnum = $pnum;

        return $this;
    }

    /**
     * Get pnum
     *
     * @return integer 
     */
    public function getPnum()
    {
        return $this->pnum;
    }

    /**
     * Set pchar
     *
     * @param string $pchar
     * @return Postcode
     */
    public function setPchar($pchar)
    {
        $this->pchar = $pchar;

        return $this;
    }

    /**
     * Get pchar
     *
     * @return string 
     */
    public function getPchar()
    {
        return $this->pchar;
    }

    /**
     * Set minnumber
     *
     * @param integer $minnumber
     * @return Postcode
     */
    public function setMinnumber($minnumber)
    {
        $this->minnumber = $minnumber;

        return $this;
    }

    /**
     * Get minnumber
     *
     * @return integer 
     */
    public function getMinnumber()
    {
        return $this->minnumber;
    }

    /**
     * Set maxnumber
     *
     * @param integer $maxnumber
     * @return Postcode
     */
    public function setMaxnumber($maxnumber)
    {
        $this->maxnumber = $maxnumber;

        return $this;
    }

    /**
     * Get maxnumber
     *
     * @return integer 
     */
    public function getMaxnumber()
    {
        return $this->maxnumber;
    }

    /**
     * Set numbertype
     *
     * @param string $numbertype
     * @return Postcode
     */
    public function setNumbertype($numbertype)
    {
        $this->numbertype = $numbertype;

        return $this;
    }

    /**
     * Get numbertype
     *
     * @return string 
     */
    public function getNumbertype()
    {
        return $this->numbertype;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Postcode
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Postcode
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId
     * @return Postcode
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return integer 
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set municipality
     *
     * @param string $municipality
     * @return Postcode
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;

        return $this;
    }

    /**
     * Get municipality
     *
     * @return string 
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * Set municipalityId
     *
     * @param integer $municipalityId
     * @return Postcode
     */
    public function setMunicipalityId($municipalityId)
    {
        $this->municipalityId = $municipalityId;

        return $this;
    }

    /**
     * Get municipalityId
     *
     * @return integer 
     */
    public function getMunicipalityId()
    {
        return $this->municipalityId;
    }

    /**
     * Set province
     *
     * @param string $province
     * @return Postcode
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return string 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set provinceCode
     *
     * @param string $provinceCode
     * @return Postcode
     */
    public function setProvinceCode($provinceCode)
    {
        $this->provinceCode = $provinceCode;

        return $this;
    }

    /**
     * Get provinceCode
     *
     * @return string 
     */
    public function getProvinceCode()
    {
        return $this->provinceCode;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Postcode
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param string $lon
     * @return Postcode
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * Get lon
     *
     * @return string 
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Set rdX
     *
     * @param string $rdX
     * @return Postcode
     */
    public function setRdX($rdX)
    {
        $this->rdX = $rdX;

        return $this;
    }

    /**
     * Get rdX
     *
     * @return string 
     */
    public function getRdX()
    {
        return $this->rdX;
    }

    /**
     * Set rdY
     *
     * @param string $rdY
     * @return Postcode
     */
    public function setRdY($rdY)
    {
        $this->rdY = $rdY;

        return $this;
    }

    /**
     * Get rdY
     *
     * @return string 
     */
    public function getRdY()
    {
        return $this->rdY;
    }

    /**
     * Set locationDetail
     *
     * @param string $locationDetail
     * @return Postcode
     */
    public function setLocationDetail($locationDetail)
    {
        $this->locationDetail = $locationDetail;

        return $this;
    }

    /**
     * Get locationDetail
     *
     * @return string 
     */
    public function getLocationDetail()
    {
        return $this->locationDetail;
    }

    /**
     * Set changedDate
     *
     * @param \DateTime $changedDate
     * @return Postcode
     */
    public function setChangedDate($changedDate)
    {
        $this->changedDate = $changedDate;

        return $this;
    }

    /**
     * Get changedDate
     *
     * @return \DateTime 
     */
    public function getChangedDate()
    {
        return $this->changedDate;
    }
}
