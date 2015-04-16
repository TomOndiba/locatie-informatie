<?php

namespace Stef\LocatieInformatieBundle\Entity;

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
     * @var string
     *
     * @ORM\Column(name="municipality", type="string", length=255)
     */
    protected $municipality;

    function __construct()
    {
        $this->locationType = "province";
    }

    /**
     * @return string
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * @param string $municipality
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;
    }
}
