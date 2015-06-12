<?php
namespace Stef\LocatieInformatieBundle\Command;

use Stef\LocatieInformatieBundle\Manager\ProvinceManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CbsConverterCommand extends AbstractConverterCommand
{
    protected function configure()
    {
        $this
            ->setName('location:convert:cbs')
            ->setDescription('Extend existing location data with CBS data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $municipalityManager = $this->getMunicipalityManager();

        /**
         * @var ProvinceManager $provinceManager
         */
        $provinceManager = $this->get('stef_simple_cms.province_manager');
        $provinces = [];

        $data = $this->loadCsv();

        foreach ($data as $row) {
            if (array_key_exists($row['p_code'], $provinces)) {
                $province = $provinces[$row['p_code']];
            } else {
                $province = $provinceManager->findByCbsCode($row['p_code']);
                $provinces[$row['p_code']] = $province;
            }

            $municipalities = $municipalityManager->findByProvinceAndName($province, $row['municipality']);

            if (count($municipalities) === 1) {
                $municipality = $municipalities[0];
                $municipality->setCbsCode($row['m_code']);

                $municipalityManager->persistAndFlush($municipality);
            }
        }
    }
}