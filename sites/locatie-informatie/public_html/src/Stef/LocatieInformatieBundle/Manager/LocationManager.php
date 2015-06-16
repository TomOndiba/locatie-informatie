<?php

namespace Stef\LocatieInformatieBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Location;
use Stef\LocatieInformatieBundle\Entity\Municipality;
use Stef\LocatieInformatieBundle\Entity\ZipCode;
use Stef\SimpleCmsBundle\Manager\AbstractObjectManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

abstract class LocationManager extends AbstractObjectManager
{
    /**
     * @var SlugManipulator
     */
    protected $slugifier;

    /**
     * @param ObjectManager $om
     * @param SlugManipulator $slugifier
     */
    function __construct(ObjectManager $om, SlugManipulator $slugifier)
    {
        $this->om = $om;
        $this->slugifier = $slugifier;
    }

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
            return 'CITY:' . $entity->getMunicipality()->getProvince()->getProvinceCode() . ':' . strtoupper(str_replace('-', '', $entity->getSlug()));
        } elseif ($entity instanceof Municipality) {
            return 'MUNI:' . $entity->getProvince()->getProvinceCode() . ':' . strtoupper(str_replace('-', '', $entity->getSlug()));
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

        if ($entity->getCreated() === null) {
            $entity->setCreated(new \DateTime());
        }

        $entity->setModified(new \DateTime());

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

    public function findByCbsCode($cbsCode)
    {
        $repo = $this->om->getRepository($this->repoName);

        $query = $repo->createQueryBuilder('c')
            ->where('c.cbsCode LIKE :cbs_code')
            ->setParameter('cbs_code', $cbsCode)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByTitle($title)
    {
        $entity = $this->om->getRepository($this->repoName)->findOneByTitle($title);

        return $entity;
    }
}