<?php

namespace Stef\LocatieInformatieBundle\Manager;

use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Location;
use Stef\LocatieInformatieBundle\Entity\Municipality;
use Stef\LocatieInformatieBundle\Entity\ZipCode;
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
        } elseif ($entity instanceof ZipCode) {
            return 'ZIP:' . $entity->getPnum() . $entity->getPchar();
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
            $entity->setLocationCode($code);
        }

        parent::persist($entity);
    }

    public function getListByFirstLetter($letter)
    {
        if ($letter === 'apostrof') {
            $letter = "'";
        }

        $repo = $this->om->getRepository($this->repoName);

        $query = $repo->createQueryBuilder('c')
            ->where('c.title LIKE :title')
            ->setParameter('title', $letter . '%')
            ->getQuery();

        return $query->getResult();
    }
}