<?php

namespace Stef\LocatieInformatieBundle\Controller;

use Stef\LocatieInformatieBundle\Conversion\CityConverter;
use Stef\LocatieInformatieBundle\Conversion\MunicipalityConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {

        //$a = new MunicipalityConverter($this->get('stef_simple_cms.postcode_manager'), $this->get('stef_simple_cms.municipality_manager'), $this->get('stef.slugifier'));
        $a = new CityConverter($this->get('stef_simple_cms.postcode_manager'), $this->get('stef_simple_cms.municipality_manager'), $this->get('stef_simple_cms.city_manager'), $this->get('stef.slugifier'));
        $a->convert();
        var_dump('erte6y4y');
    }
}