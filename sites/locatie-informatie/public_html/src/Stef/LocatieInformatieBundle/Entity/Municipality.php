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
    function __construct()
    {
        $this->locationType = "municipality";
    }
}
