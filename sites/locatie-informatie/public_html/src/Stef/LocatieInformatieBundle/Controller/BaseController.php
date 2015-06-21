<?php

namespace Stef\LocatieInformatieBundle\Controller;

use Stef\LocatieInformatieBundle\Manager\CityManager;
use Stef\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stef\LocatieInformatieBundle\Manager\ProvinceManager;
use Stef\LocatieInformatieBundle\Manager\ZipcodeManager;
use Stef\SimpleCmsBundle\Manager\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @return CityManager
     */
    public function getCityManager()
    {
        return $this->get('stef_simple_cms.city_manager');
    }

    /**
     * @return MunicipalityManager
     */
    public function getMunicipalityManager()
    {
        return $this->get('stef_simple_cms.municipality_manager');
    }

    /**
     * @return ProvinceManager
     */
    public function getProvinceManager()
    {
        return $this->get('stef_simple_cms.province_manager');
    }

    /**
     * @return ZipcodeManager
     */
    public function getZipcodeManager()
    {
        return $this->get('stef_simple_cms.zipcode_manager');
    }

    /**
     * @return PageManager
     */
    public function getPageManager()
    {
        return $this->get('stef_simple_cms.page_manager');
    }
}