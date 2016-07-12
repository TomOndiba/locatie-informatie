<?php

namespace Stef\LocatieInformatieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Province extends Location
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Municipality", mappedBy="province")
     */
    protected $municipalities;

    /**
     * @var string
     *
     * @ORM\Column(name="province_code", type="string", length=3)
     */
    protected $provinceCode;

    function __construct()
    {
        $this->locationType = "province";
        $this->municipalities = new ArrayCollection();
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

    /**
     * @return ArrayCollection
     */
    public function getMunicipalities()
    {
        return $this->municipalities;
    }

    /**
     * @param ArrayCollection $municipalities
     */
    public function setMunicipalities($municipalities)
    {
        $this->municipalities = $municipalities;
    }
}
