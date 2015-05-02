<?php

namespace Stef\LocatieInformatieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Municipality
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Municipality extends Location
{
    /**
     * @var string
     *
     * @ORM\Column(name="province_code", type="string", length=3)
     */
    protected $province_code;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="City", mappedBy="municipality")
     */
    protected $cities;

    function __construct()
    {
        $this->locationType = "municipality";
        $this->cities= new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getProvinceCode()
    {
        return $this->province_code;
    }

    /**
     * @param string $province_code
     */
    public function setProvinceCode($province_code)
    {
        $this->province_code = $province_code;
    }

    /**
     * @return ArrayCollection
     */
    public function getCities()
    {
        return $this->cities;
    }
}
