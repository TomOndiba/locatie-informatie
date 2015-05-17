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
     * @var Province
     *
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="municipalities")
     */
    protected $province;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="City", mappedBy="municipality")
     */
    protected $cities;

    function __construct()
    {
        $this->locationType = "municipality";
        $this->cities = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @return Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param Province $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }
}
