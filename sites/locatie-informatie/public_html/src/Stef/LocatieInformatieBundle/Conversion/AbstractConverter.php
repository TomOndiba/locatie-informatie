<?php
namespace Stef\LocatieInformatieBundle\Conversion;


use Stef\LocatieInformatieBundle\Entity\Location;
use Stef\LocatieInformatieBundle\Entity\Postcode;

abstract class AbstractConverter {

    /**
     * @param Location $location
     * @param Postcode $postcode
     *
     * @return Location
     */
    protected function copyFields(Location $location, Postcode $postcode)
    {
        $location->setLat($postcode->getLat());
        $location->setLng($postcode->getLon());
        $location->setLocationDetail($postcode->getLocationDetail());
        $location->setRdX($postcode->getRdX());
        $location->setRdY($postcode->getRdY());
        $location->setCreated($postcode->getChangedDate());
        $location->setModified($postcode->getChangedDate());

        return $location;
    }
}