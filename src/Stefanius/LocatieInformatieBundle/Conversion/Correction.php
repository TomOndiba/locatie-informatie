<?php
namespace Stefanius\LocatieInformatieBundle\Conversion;

use Stefanius\LocatieInformatieBundle\Entity\City;
use Stefanius\LocatieInformatieBundle\Entity\Postcode;
use Stefanius\LocatieInformatieBundle\Entity\Location;
use Stefanius\LocatieInformatieBundle\Entity\Municipality;
use Stefanius\LocatieInformatieBundle\Entity\ZipCode;
use Stefanius\LocatieInformatieBundle\Manager\CityManager;
use Stefanius\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stefanius\LocatieInformatieBundle\Manager\ProvinceManager;
use Stefanius\LocatieInformatieBundle\Manager\ZipcodeManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

class Correction
{
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

    /**
     * @var ProvinceManager
     */
    protected $provinceManager;

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

    /**
     * @param ProvinceManager $provinceManager
     */
    public function setProvinceManager($provinceManager)
    {
        $this->provinceManager = $provinceManager;
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
        } elseif ($postcode->getMunicipality() === 'Scherpenzeel' && $postcode->getProvinceCode() === 'ZH') {
            $location = $this->manipulate($postcode, $location, 'GE');
        } elseif ($postcode->getMunicipality() === 'Maasdonk' && $postcode->getProvinceCode() === 'NB') {
            if ($postcode->getCity() === 'Geffen') {
                $postcode->setMunicipality('Oss');
            } else if ($postcode->getCity() === 'Vinkel' || $postcode->getCity() === 'Nuland') {
                $postcode->setMunicipality('\'s‑Hertogenbosch');
            } else {
                var_dump('CORRECTIO ERROR:   ' . $postcode->getCity());
            }

            $location = $this->manipulate($postcode, $location, 'GE');
        } else {
            $location = $this->manipulate($postcode, $location, $postcode->getProvinceCode());
        }

        return $location;
    }

    public function manipulate(Postcode $postcode, Location $location, $provinceCode)
    {
        if ($location instanceof Municipality) {
            $province = $this->provinceManager->getRepository()->findOneByProvinceCode($provinceCode);
            $location->setProvince($province);
            $location->setTitleLng('Gemeente ' . $location->getTitle());
            $location->setSlug('gem-' . $this->slugifier->manipulate($location->getTitle() . '-' . $provinceCode));
        } elseif ($location instanceof City) {
            $province = $this->provinceManager->getRepository()->findOneByProvinceCode($provinceCode);
            $municipality = $this->municipalityManager->getRepository()->findOneBy(['province' => $province, 'title' => $postcode->getMunicipality()]);
            $location->setMunicipality($municipality);
        } elseif ($location instanceof ZipCode) {
            $municipality = $this->municipalityManager->getRepository()->findOneBySlug('gem-' . $this->slugifier->manipulate($postcode->getMunicipality() . '-' . $provinceCode));
            $city = $this->cityManager->getRepository()->findOneBy(['municipality' => $municipality, 'title' => $postcode->getCity()]);

            $location->setCity($city);
        }

        return $location;
    }
}