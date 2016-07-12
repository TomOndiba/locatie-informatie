<?php

namespace Stefanius\LocatieInformatieBundle\Executor;

use Stefanius\LocatieInformatieBundle\Conversion\CityConverter;
use Stefanius\LocatieInformatieBundle\Conversion\MunicipalityConverter;
use Stefanius\LocatieInformatieBundle\Conversion\ZipcodeConverter;
use Stefanius\LocatieInformatieBundle\Manager\CityManager;
use Stefanius\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stefanius\LocatieInformatieBundle\Manager\PostcodeManager;
use Stefanius\LocatieInformatieBundle\Manager\ProvinceManager;
use Stefanius\LocatieInformatieBundle\Manager\StreetManager;
use Stefanius\LocatieInformatieBundle\Manager\ZipcodeManager;
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
     * @var StreetManager
     */
    protected $streetManager;

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
     * @param StreetManager $streetManager
     */
    function __construct(PostcodeManager $postcodeManager, ProvinceManager $provinceManager, MunicipalityManager $municipalityManager, CityManager $cityManager, ZipcodeManager $zipcodeManager, StreetManager $streetManager)
    {
        $this->postcodeManager = $postcodeManager;
        $this->provinceManager = $provinceManager;
        $this->municipalityManager = $municipalityManager;
        $this->cityManager = $cityManager;
        $this->zipcodeManager = $zipcodeManager;
        $this->streetManager = $streetManager;
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
            $converter = new MunicipalityConverter($this->postcodeManager, $this->provinceManager, $this->municipalityManager, $this->cityManager, $this->zipcodeManager, $this->streetManager, new SlugManipulator());
        } elseif ($targetLocationType === 'city') {
            $converter = new CityConverter($this->postcodeManager, $this->provinceManager, $this->municipalityManager, $this->cityManager, $this->zipcodeManager, $this->streetManager, new SlugManipulator());
        } elseif ($targetLocationType === 'zipcode') {
            $converter = new ZipcodeConverter($this->postcodeManager, $this->provinceManager, $this->municipalityManager, $this->cityManager, $this->zipcodeManager, $this->streetManager, new SlugManipulator());
        }

        if ($converter != null) {
            return $converter->convert($postcodeId);
        }

        return false;
    }
}