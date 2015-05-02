<?php

namespace Stef\LocatieInformatieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class City extends Location
{
    /**
     * @var Municipality
     *
     * @ORM\ManyToOne(targetEntity="Municipality", inversedBy="cities")
     */
    protected $municipality;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ZipCode", mappedBy="city")
     */
    protected $zipCodes;

    function __construct()
    {
        $this->locationType = "city";
    }

    /**
     * @return Municipality
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * @param Municipality $municipality
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;
    }
}
