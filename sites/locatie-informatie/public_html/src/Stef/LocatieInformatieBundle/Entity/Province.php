<?php

namespace Stef\LocatieInformatieBundle\Entity;

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
     * @var string
     *
     * @ORM\Column(name="province_code", type="string", length=3)
     */
    protected $province_code;

    function __construct()
    {
        $this->locationType = "province";
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
