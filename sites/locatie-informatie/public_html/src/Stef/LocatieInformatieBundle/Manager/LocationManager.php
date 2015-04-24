<?php

namespace Stef\LocatieInformatieBundle\Manager;

use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Location;
use Stef\LocatieInformatieBundle\Entity\Municipality;
use Stef\SimpleCmsBundle\Manager\AbstractObjectManager;

abstract class LocationManager extends AbstractObjectManager
{
    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository()
    {
        return $this->om->getRepository($this->repoName);
    }

    /**
     * @param Location $entity
     * @return string
     */
    protected function createLocationCode($entity)
    {
        if ($entity instanceof City) {
            var_dump( $entity->getSlug());
            return 'CITY:' . $entity->getMunicipality()->getProvinceCode() . ':' . strtoupper(str_replace('-', '', $entity->getSlug()));
        } elseif ($entity instanceof Municipality) {
            return 'MUNI:' . $entity->getProvinceCode() . ':' . strtoupper(str_replace('-', '', $entity->getSlug()));
        }

        return null;
    }

    /**
     * @param Location $entity
     */
    public function persist($entity)
    {
        if (empty($entity->getTitleLng()) ) {
            $entity->setTitleLng($entity->getTitle());
        }

        if (empty($entity->getLocationCode())) {
            $code = $this->createLocationCode($entity);
            var_dump('$code: ' . $code);
            $entity->setLocationCode($code);
        }

        parent::persist($entity);
    }
}