<?php

namespace Stef\LocatieInformatieBundle\Manager;

use Doctrine\Entity;
use Stef\LocatieInformatieBundle\Entity\Province;
use Symfony\Component\HttpFoundation\ParameterBag;

class ProvinceManager extends LocationManager
{
    protected $repoName = 'StefLocatieInformatieBundle:Province';

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
     * @return Province
     */
    public function read($key)
    {
        $entity = parent::read($key);

        if ($entity === null) {
            $entity = $this->om->getRepository($this->repoName)->findOneBySlug($key);
        }

        return $entity;
    }
}