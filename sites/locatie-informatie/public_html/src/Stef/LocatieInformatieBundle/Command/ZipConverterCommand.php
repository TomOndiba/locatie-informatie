<?php
namespace Stef\LocatieInformatieBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ZipConverterCommand extends AbstractConverterCommand
{
    protected function configure()
    {
        $this
            ->setName('location:convert:sqlzip')
            ->setDescription('Finaly convert the zipcodes')
            ->addArgument('province')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $provinceCode = strtoupper($input->getArgument('province'));

        $postcodeManager = $this->get('stef_simple_cms.postcode_manager');
        $queueManager = $this->get('tree_house.worker.queue_manager');

        $limit = 750;

        for($page = 0; $page < 1000; $page++) {
            $entities = $postcodeManager->getRepository()->findBy(['provinceCode' => $provinceCode], [], $limit, ($page * $limit));
            $this->dispatch($entities, $queueManager, 'zipcode');
            exit;
            var_dump(count($entities) . ' -- PAGE -- ' . $page);

            if ($page > 100 && count($entities) === 0) {
                echo "\n\n BREAK \n\n";
                break;
            }

        }
    }

    protected function dispatch($entities, $queueManager, $type)
    {
        foreach($entities as $entity) {
            var_dump($entity->getStreet() . '   --   ' . $entity->getPostcode());
            $queueManager->add('convert.locations', [$entity->getId(), $type]);
        }
    }
}