<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        setlocale(LC_ALL, 'nl_NL');
        \Carbon\Carbon::setLocale('nl');

        $bundles = [
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
            /*FrequenceWeb*/
            new FrequenceWeb\Bundle\CalendRBundle\FrequenceWebCalendRBundle(),
            /*Braincrafted */
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            /* FOS*/
            new FOS\UserBundle\FOSUserBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            /* Ivory */
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            /* WhiteOctober */
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),

            new Leezy\PheanstalkBundle\LeezyPheanstalkBundle(),
            new TreeHouse\WorkerBundle\TreeHouseWorkerBundle(),
            /* Stefanius */
            new Stefanius\SimpleCmsBundle\StefSimpleCmsBundle(),
            new Stefanius\LocatieInformatieBundle\StefLocatieInformatieBundle(),
            new Stefanius\RedirectTrailingSlashBundle\StefaniusRedirectTrailingSlashBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
