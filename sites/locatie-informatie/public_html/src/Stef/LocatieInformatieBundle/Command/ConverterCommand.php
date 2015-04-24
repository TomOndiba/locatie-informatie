<?php
namespace Stef\LocatieInformatieBundle\Command;

use Stef\LocatieInformatieBundle\Conversion\CityConverter;
use Stef\LocatieInformatieBundle\Conversion\MunicipalityConverter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConverterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('location:convert')
            ->setDescription('Convert Locationdata in our own format.')
        ;
    }

    protected function get($service)
    {
        return $this->getApplication()->getKernel()->getContainer()->get($service);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $municipalityConverter = new MunicipalityConverter($this->get('stef_simple_cms.postcode_manager'), $this->get('stef_simple_cms.municipality_manager'), $this->get('stef.slugifier'));
        $municipalityConverter->convert();

        $cityConverter = new CityConverter($this->get('stef_simple_cms.postcode_manager'), $this->get('stef_simple_cms.municipality_manager'), $this->get('stef_simple_cms.city_manager'), $this->get('stef.slugifier'));
        $cityConverter->convert();
    }
}