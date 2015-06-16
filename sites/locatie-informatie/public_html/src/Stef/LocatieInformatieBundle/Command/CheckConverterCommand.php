<?php
namespace Stef\LocatieInformatieBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckConverterCommand extends AbstractConverterCommand
{
    protected function configure()
    {
        $this
            ->setName('location:convert:check')
            ->setDescription('check the municipalities')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $municipalityManager = $this->getMunicipalityManager();

        $notfound = [];

        $data = $this->loadCsv();

        foreach ($data as $row) {
            $municipality = $municipalityManager->findByCbsCode($row['m_code']);

            if ($municipality === null) {
                $notfound[] = $row;
            }
        }

        if (count($notfound) > 0) {
            foreach ($notfound as $nf) {
                echo "Municipality not found in database: " . json_encode($nf) . "\n";
            }
        }
    }
}