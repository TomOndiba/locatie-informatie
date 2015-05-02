<?php
namespace Stef\LocatieInformatieBundle\Conversion;


use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Postcode;
use Stef\LocatieInformatieBundle\Entity\Location;
use Stef\LocatieInformatieBundle\Entity\Municipality;
use Stef\LocatieInformatieBundle\Entity\ZipCode;
use Stef\LocatieInformatieBundle\Manager\CityManager;
use Stef\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stef\LocatieInformatieBundle\Manager\ZipcodeManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

class Correction {

    protected $slugifier;

    /**
     * @var MunicipalityManager
     */
    protected $municipalityManager;

    /**
     * @var ZipcodeManager
     */
    protected $zipCodeManager;

    /**
     * @var CityManager
     */
    protected $cityManager;

    function __construct()
    {
        $this->slugifier = new SlugManipulator();
    }

    /**
     * @param MunicipalityManager $municipalityManager
     */
    public function setMunicipalityManager($municipalityManager)
    {
        $this->municipalityManager = $municipalityManager;
    }

    /**
     * @param ZipcodeManager $zipCodeManager
     */
    public function setZipCodeManager($zipCodeManager)
    {
        $this->zipCodeManager = $zipCodeManager;
    }

    /**
     * @param CityManager $cityManager
     */
    public function setCityManager($cityManager)
    {
        $this->cityManager = $cityManager;
    }


    public function correct(Location $location, Postcode $postcode)
    {
        if ($postcode->getMunicipality() === 'Peel en Maas' && $postcode->getProvinceCode() === 'NB') {
            $location = $this->manipulate($postcode, $location, 'LI');
        } elseif ($postcode->getMunicipality() === 'Deventer' && $postcode->getProvinceCode() === 'GE') {
            $location = $this->manipulate($postcode, $location, 'OV');
        } elseif ($postcode->getMunicipality() === 'Bergen (L.)' && $postcode->getProvinceCode() === 'FL') {
            $location = $this->manipulate($postcode, $location, 'LI');
        } elseif ($postcode->getMunicipality() === 'Meerssen' && $postcode->getProvinceCode() === 'ZH') {
            $location = $this->manipulate($postcode, $location, 'LI');
        } elseif ($postcode->getMunicipality() === 'Tynaarlo' && $postcode->getProvinceCode() === 'FR') {
            $location = $this->manipulate($postcode, $location, 'DR');
        } elseif ($postcode->getMunicipality() === 'Aa en Hunze' && $postcode->getProvinceCode() === 'GE') {
            $location = $this->manipulate($postcode, $location, 'DR');
        } elseif ($postcode->getMunicipality() === 'Amersfoort' && $postcode->getProvinceCode() === 'ZH') {
            $location = $this->manipulate($postcode, $location, 'UT');
        } elseif ($postcode->getMunicipality() === 'Kaag en Braassem' && $postcode->getProvinceCode() === 'NH') {
            $location = $this->manipulate($postcode, $location, 'ZH');
        } elseif ($postcode->getMunicipality() === 'Steenwijkerland' && $postcode->getProvinceCode() === 'DR') {
            $location = $this->manipulate($postcode, $location, 'OV');
        } elseif ($postcode->getMunicipality() === 'Zwartewaterland' && $postcode->getProvinceCode() === 'GE') {
            $location = $this->manipulate($postcode, $location, 'OV');
        } else {
            $location = $this->manipulate($postcode, $location, $postcode->getProvinceCode());
        }

        return $location;
    }

    public function manipulate(Postcode $postcode, Location $location, $provinceCode)
    {
        if ($location instanceof Municipality) {
            $location->setProvinceCode($provinceCode);
            $location->setTitleLng('Gemeente ' . $location->getTitle());
            $location->setSlug('gem-' . $this->slugifier->manipulate($location->getTitle() . '-' . $provinceCode));
        } elseif ($location instanceof City) {
            $municipality = $this->municipalityManager->getRepository()->findOneBy(['province_code' => $provinceCode, 'title' => $postcode->getMunicipality()]);
            $location->setMunicipality($municipality);
        } elseif ($location instanceof ZipCode) {
            $municipality = $this->municipalityManager->getRepository()->findOneBySlug('gem-' . $this->slugifier->manipulate($postcode->getMunicipality() . '-' . $provinceCode));
            $city = $this->cityManager->getRepository()->findOneBy(['municipality' => $municipality, 'title' => $postcode->getCity()]);
            $location->setCity($city);
        }

        return $location;
    }
}