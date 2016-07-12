<?php

namespace Stefanius\LocatieInformatieBundle\Manager;

use Doctrine\Entity;
use Symfony\Component\HttpFoundation\ParameterBag;

class PostcodeManager extends LocationManager
{
    protected $repoName = 'StefLocatieInformatieBundle:Postcode';

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

    public function getAllRecords()
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        $qb->select('e')->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }

}