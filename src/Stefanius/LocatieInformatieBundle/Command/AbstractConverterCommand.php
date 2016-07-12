<?php

namespace Stefanius\LocatieInformatieBundle\Command;

use Stefanius\LocatieInformatieBundle\Manager\CityManager;
use Stefanius\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stefanius\LocatieInformatieBundle\Manager\ProvinceManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\HttpFoundation\File\File;

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

    protected function loadCsv()
    {
        $file = new File(dirname(__FILE__) . '/../Resources/cbs_data/municiplicity_province2015.csv');
        $header = [];
        $rowno = 0;
        $data = [];

        if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
            while(($row = fgetcsv($handle)) !== FALSE) {

                if ($rowno === 0) {
                    $header = $row;
                } else {
                    foreach ($header as $key => $value) {
                        $data[$rowno][$value] = $row[$key];
                    }
                }
                $rowno++;
            }
        }

        return $data;
    }
}