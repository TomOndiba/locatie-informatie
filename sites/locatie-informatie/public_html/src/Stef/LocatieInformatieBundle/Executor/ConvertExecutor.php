<?php

namespace Stef\LocatieInformatieBundle\Executor;

use Stef\LocatieInformatieBundle\Conversion\CityConverter;
use Stef\LocatieInformatieBundle\Conversion\MunicipalityConverter;
use Stef\LocatieInformatieBundle\Conversion\ZipcodeConverter;
use Stef\LocatieInformatieBundle\Manager\CityManager;
use Stef\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stef\LocatieInformatieBundle\Manager\PostcodeManager;
use Stef\LocatieInformatieBundle\Manager\ProvinceManager;
use Stef\LocatieInformatieBundle\Manager\ZipcodeManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TreeHouse\WorkerBundle\Executor\AbstractExecutor;

class ConvertExecutor extends AbstractExecutor
{
    /**
     * @var PostcodeManager
     */
    protected $postcodeManager;

    /**
     * @var ProvinceManager
     */
    protected $provinceManager;

    /**
     * @var MunicipalityManager
     */
    protected $municipalityManager;

    /**
     * @var CityManager
     */
    protected $cityManager;

    /**
     * @var ZipcodeManager
     */
    protected $zipcodeManager;

    /**
     * @var SlugManipulator
     */
    protected $slugifier;

    /**
     * @param PostcodeManager $postcodeManager
     * @param ProvinceManager $provinceManager
     * @param MunicipalityManager $municipalityManager
     * @param CityManager $cityManager
     * @param ZipcodeManager $zipcodeManager
     */
    function __construct(PostcodeManager $postcodeManager, ProvinceManager $provinceManager, MunicipalityManager $municipalityManager, CityManager $cityManager, ZipcodeManager $zipcodeManager)
    {
        $this->postcodeManager = $postcodeManager;
        $this->provinceManager = $provinceManager;
        $this->municipalityManager = $municipalityManager;
        $this->cityManager = $cityManager;
        $this->zipcodeManager = $zipcodeManager;
    }

    public function getName()
    {
        return 'convert.locations';
    }

    public function configurePayload(OptionsResolver $resolver)
    {
        $resolver->setRequired([0, 1]);
    }

    public function execute(array $payload)
    {
        $postcodeId = array_shift($payload);
        $targetLocationType = array_shift($payload);
        $converter = null;

        if ($targetLocationType === 'municipality') {
            $converter = new MunicipalityConverter($this->postcodeManager, $this->provinceManager, $this->municipalityManager, $this->cityManager, $this->zipcodeManager, new SlugManipulator());
        } elseif ($targetLocationType === 'city') {
            $converter = new CityConverter($this->postcodeManager, $this->provinceManager, $this->municipalityManager, $this->cityManager, $this->zipcodeManager, new SlugManipulator());
        } elseif ($targetLocationType === 'zipcode') {
            $converter = new ZipcodeConverter($this->postcodeManager, $this->provinceManager, $this->municipalityManager, $this->cityManager, $this->zipcodeManager, new SlugManipulator());
        }

        if ($converter != null) {
            return $converter->convert($postcodeId);
        }

        return false;
    }
}