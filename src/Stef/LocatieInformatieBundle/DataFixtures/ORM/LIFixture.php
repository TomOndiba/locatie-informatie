<?php

namespace Stef\LocatieInformatieBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\Yaml;
use Nelmio\Alice\ORM\Doctrine;
use Symfony\Component\Finder\Finder;

class LIFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new Yaml();
        $finder = new Finder();
        $fixtures = $finder
            ->in(__DIR__. '/../../Resources/fixtures/')
            ->files()
            ->name('*.yml')
            ->sortByName()
        ;

        foreach ($fixtures as $file) {
            $objects = $loader->load($file);

            $this->loadObjects($manager, $objects);
        }

        $manager->flush();
    }

    protected function loadObjects(ObjectManager $manager, $objects)
    {
        $persister = new Doctrine($manager);
        $persister->persist($objects);
    }
}