<?php

namespace Stef\LocatieInformatieBundle\Manager;

use Doctrine\Entity;
use Stef\LocatieInformatieBundle\Entity\Municipality;
use Symfony\Component\HttpFoundation\ParameterBag;

class CityManager extends LocationManager
{
    protected $repoName = 'StefLocatieInformatieBundle:City';

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

    public function findByMunicipality(Municipality $municipality)
    {
        $entity = $this->om->getRepository($this->repoName)->findByMunicipality($municipality);

        return $entity;
    }
}