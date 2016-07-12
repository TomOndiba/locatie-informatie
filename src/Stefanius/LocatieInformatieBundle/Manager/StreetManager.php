<?php

namespace Stefanius\LocatieInformatieBundle\Manager;

use Doctrine\Entity;
use Stefanius\LocatieInformatieBundle\Entity\City;
use Stefanius\LocatieInformatieBundle\Entity\ZipCode;
use Symfony\Component\HttpFoundation\ParameterBag;

class StreetManager extends LocationManager
{
    protected $repoName = 'StefLocatieInformatieBundle:Street';

    /**
     * @param ParameterBag $data
     *
     * @return Entity
     */
    public function create(ParameterBag $data)
    {
        /*
        $news = new News();

        $news->setTitle($data->get('title'));
        $news->setBody($data->get('body'));
        $news->setPicture($data->get('picture'));
        $news->setSlug($this->slugifier->manipulate($news->getTitle() . '-' . rand(100 , 999)));

        return $news; */
    }

    public function persist($entity)
    {
        if ($entity->getSlug() === null) {
            $entity->setSlug($this->slugifier->manipulate($entity->getTitle() . '-' . rand(100, 999)));
        }

        parent::persist($entity);
    }


    /**
     * @param $key
     * @return mixed
     */
    public function read($key)
    {
        $entity = parent::read($key);

        if ($entity === null) {
            $entity = $this->om->getRepository($this->repoName)->findOneBySlug($key);
        }

        return $entity;
    }

    /**
     * @param City $city
     * @param $title
     * @return mixed
     */
    public function findByCityAndName(City $city, $title)
    {
        $repo = $this->om->getRepository($this->repoName);

        $query = $repo->createQueryBuilder('m')
            ->where('m.city = :city')
            ->andWhere('m.title = :title')
            ->setParameter('title', trim($title))
            ->setParameter('city', $city)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}