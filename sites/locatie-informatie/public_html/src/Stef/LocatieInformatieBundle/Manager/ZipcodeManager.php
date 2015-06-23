<?php

namespace Stef\LocatieInformatieBundle\Manager;

use Doctrine\Entity;
use Symfony\Component\HttpFoundation\ParameterBag;

class ZipcodeManager extends LocationManager
{
    protected $repoName = 'StefLocatieInformatieBundle:ZipCode';

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

    public function findByPnum($pnum)
    {
        $repo = $this->om->getRepository($this->repoName);

        $query = $repo->createQueryBuilder('z')
            ->where('z.pnum = :pnum')
            ->setParameter('pnum', $pnum)
            ->orderBy('z.slug', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}