<?php
namespace Stefanius\LocatieInformatieBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConverterCommand extends AbstractConverterCommand
{
    protected function configure()
    {
        $this
            ->setName('location:convert:sql')
            ->setDescription('Convert existing SQL Locationdata in our own format. Send the data to convert to a message queue.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $postcodeManager = $this->get('stef_simple_cms.postcode_manager');
        $qbPostcode = $postcodeManager->getRepository()->createQueryBuilder('p');
        $queueManager = $this->get('tree_house.worker.queue_manager');

        $this->dispatch($qbPostcode->select('p')->groupBy('p.municipality')->getQuery()->getResult(), $queueManager, 'municipality');
        $this->dispatch($qbPostcode->select('p')->groupBy('p.municipalityId')->getQuery()->getResult(), $queueManager, 'municipality');

        $this->dispatch($qbPostcode->select('p')->groupBy('p.city')->getQuery()->getResult(), $queueManager, 'city');
        $this->dispatch($qbPostcode->select('p')->groupBy('p.cityId')->getQuery()->getResult(), $queueManager, 'city');
    }

    protected function dispatch($entities, $queueManager, $type)
    {
        foreach($entities as $entity) {
            $queueManager->add('convert.locations', [$entity->getId(), $type]);
        }
    }
}