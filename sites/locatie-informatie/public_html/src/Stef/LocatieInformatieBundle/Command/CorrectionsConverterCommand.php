<?php
namespace Stef\LocatieInformatieBundle\Command;

use Stef\LocatieInformatieBundle\Entity\Municipality;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CorrectionsConverterCommand extends AbstractConverterCommand
{
    protected function configure()
    {
        $this
            ->setName('location:convert:corrections')
            ->setDescription('Correct the latest municiplicities')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->createNewMunicipalities([
            'title' => 'Nissewaard',
            'cbs_code' => '1930',
            'province_cbs_code' => '28',
        ]);

        $this->createNewMunicipalities([
            'title' => 'Krimpenerwaard',
            'cbs_code' => '1931',
            'province_cbs_code' => '28',
        ]);

        $this->correct(['Alkmaar', '0361'], [['Graft-De Rijp', '0365'], ['Schermer', '0458']]);
        $this->correct(['Groesbeek', '0241'], [['Millingen aan de Rijn', '0265'], ['Ubbergen', '0282']]);
        $this->correct(['Nissewaard', '1930'], [['Bernisse', '0568'], ['Spijkenisse', '0612']]);
        $this->correct(['Krimpenerwaard', '1931'], [['Bergambacht', '0491'], ['Nederlek', '0643'], ['Ouderkerk', '0644'], ['Vlist', '0623'], ['Schoonhoven', '0608']]);
    }

    protected function createNewMunicipalities($values = [])
    {
        $municipalityManager = $this->getMunicipalityManager();

        if ($municipalityManager->findByCbsCode($values['cbs_code']) !== null) {
            return;
        }

        $municipality = new Municipality();
        $municipality->setTitle($values['title']);
        $municipality->setCbsCode($values['cbs_code']);
        $municipality->setProvince($this->getProvinceManager()->findByCbsCode($values['province_cbs_code']));
        $municipality->setLat(0);
        $municipality->setLng(0);

        $municipalityManager->persistAndFlush($municipality);

        echo "Municipality " . $municipality->getTitle() . " is created.";
    }

    protected function correct($target = [], $olds = [])
    {
        $municipalityManager = $this->getMunicipalityManager();
        $cityManager = $this->getCityManager();

        $targetMunicipality = $municipalityManager->findByCbsCode($target[1]);

        foreach ($olds as $old) {
            $oldMunicipality = $municipalityManager->findByCbsCode($old[1]);

            if ($oldMunicipality === null) {
                $oldMunicipality = $municipalityManager->findOneByTitle($old[0]);
            }

            $cities = $cityManager->findByMunicipality($oldMunicipality);

            if ($oldMunicipality !== null && $targetMunicipality !== null) {
                foreach($cities as $city) {
                    $city->setMunicipality($targetMunicipality);
                    $cityManager->persistAndFlush($city);
                    echo $city->getTitle() . " is moved from '" . $oldMunicipality->getTitle() . "' to '" . $targetMunicipality->getTitle() . "'\n";
                }

                $municipalityManager->remove($oldMunicipality);
            } else {
                echo "Something may be wrong. One or both municipalities are NULL: " . json_encode($target) . " -- " . json_encode($olds);
            }
        }
    }
}