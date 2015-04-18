<?php

namespace Stef\LocatieInformatieBundle\Entity;

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

    function __construct()
    {
        $this->locationType = "municipality";
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
}
