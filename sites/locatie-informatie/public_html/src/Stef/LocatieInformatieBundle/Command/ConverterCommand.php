<?php
namespace Stef\LocatieInformatieBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConverterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('location:convert')
            ->setDescription('Convert Locationdata in our own format. Send the data to convert to a messageqeue.')
        ;
    }

    protected function get($service)
    {
        return $this->getApplication()->getKernel()->getContainer()->get($service);
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

        /*
        $limit = 500;

        for($page = 0; $page < 1000; $page++) {
            $entities = $postcodeManager->getRepository()->findBy([], [], $limit, ($page * $limit));
            $this->dispatch($entities, $queueManager, 'zipcode');
        }
        */
    }

    protected function dispatch($entities, $queueManager, $type)
    {
        foreach($entities as $entity) {
            $queueManager->add('convert.locations', [$entity->getId(), $type]);
        }
    }
}