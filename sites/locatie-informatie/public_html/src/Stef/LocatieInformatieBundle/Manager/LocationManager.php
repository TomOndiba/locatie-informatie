<?php

namespace Stef\LocatieInformatieBundle\Manager;

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
}