<?php

namespace Stef\LocatieInformatieBundle\Command;

use Stef\LocatieInformatieBundle\Manager\CityManager;
use Stef\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stef\LocatieInformatieBundle\Manager\ProvinceManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class AbstractConverterCommand extends ContainerAwareCommand
{
    protected function get($service)
    {
        return $this->getApplication()->getKernel()->getContainer()->get($service);
    }

    /**
     * @return MunicipalityManager
     */
    protected function getMunicipalityManager()
    {
        return $this->get('stef_simple_cms.municipality_manager');
    }

    /**
     * @return CityManager
     */
    protected function getCityManager()
    {
        return $this->get('stef_simple_cms.city_manager');
    }

    /**
     * @return ProvinceManager
     */
    protected function getProvinceManager()
    {
        return $this->get('stef_simple_cms.province_manager');
    }
}