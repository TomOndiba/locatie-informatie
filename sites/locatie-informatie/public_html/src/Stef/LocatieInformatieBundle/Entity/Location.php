<?php

namespace Stef\LocatieInformatieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="rdX", type="decimal", precision=31, scale=20, nullable=true)
     */
    protected $rdX;

    /**
     * @var string
     *
     * @ORM\Column(name="rdY", type="decimal", precision=31, scale=20, nullable=true)
     */
    protected $rdY;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="decimal", precision=15, scale=13, nullable=true)
     */
    protected $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="decimal", precision=15, scale=13, nullable=true)
     */
    protected $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="location_code", type="string", length=15, nullable=true)
     */
    protected $locationCode;

    /**
     * @var string
     *
     * @ORM\Column(name="location_type", type="string", length=50)
     */
    protected $locationType;

    /**
     * @var string
     *
     * The level of detail of the GEO markers.
     *
     * @ORM\Column(name="location_detail", type="string", length=50)
     */
    protected $locationDetail;

    /**
     * @var integer
     *
     * Filled with the data from the original city_id, municipality_id or postcode_id
     *
     * @ORM\Column(name="source_location_type_id", type="integer")
     */
    protected $sourceLocationTypeId;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    protected $modified;

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
     * Set slug
     *
     * @param string $slug
     * @return Location
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Location
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set rdX
     *
     * @param string $rdX
     * @return Location
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
     * @return Location
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
     * Set lat
     *
     * @param string $lat
     * @return Location
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
     * Set lng
     *
     * @param string $lng
     * @return Location
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set locationCode
     *
     * @param string $locationCode
     * @return Location
     */
    public function setLocationCode($locationCode)
    {
        $this->locationCode = $locationCode;

        return $this;
    }

    /**
     * Get locationCode
     *
     * @return string 
     */
    public function getLocationCode()
    {
        return $this->locationCode;
    }

    /**
     * Set locationType
     *
     * @param string $locationType
     * @return Location
     */
    public function setLocationType($locationType)
    {
        $this->locationType = $locationType;

        return $this;
    }

    /**
     * Get locationType
     *
     * @return string 
     */
    public function getLocationType()
    {
        return $this->locationType;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getLocationDetail()
    {
        return $this->locationDetail;
    }

    /**
     * @param string $locationDetail
     */
    public function setLocationDetail($locationDetail)
    {
        $this->locationDetail = $locationDetail;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param \DateTime $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }
}
