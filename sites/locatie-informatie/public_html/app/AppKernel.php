<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function __construct($environment, $debug)
    {
        date_default_timezone_set('Europe/Amsterdam');
        parent::__construct($environment, $debug);
    }

    public function registerBundles()
    {
        $bundles = array(
            /*Symfony / Doctrine / Sensio Core */
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            /*Braincrafted */
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            /* TreeHouseLabs */
            new TreeHouse\WorkerBundle\TreeHouseWorkerBundle(),
            /* FOS*/
            new FOS\UserBundle\FOSUserBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            /* Ivory */
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Ivory\GoogleMapBundle\IvoryGoogleMapBundle(),
            /* WhiteOctober */
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
            /* Stefanius */
            new Stef\SimpleCmsBundle\StefSimpleCmsBundle(),
            new Stef\RedirectTrailingSlashBundle\StefRedirectTrailingSlashBundle(),
            new Stef\LocatieInformatieBundle\StefLocatieInformatieBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
