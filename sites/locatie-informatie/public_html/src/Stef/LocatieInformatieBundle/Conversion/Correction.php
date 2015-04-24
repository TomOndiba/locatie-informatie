<?php
namespace Stef\LocatieInformatieBundle\Conversion;


use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Postcode;
use Stef\LocatieInformatieBundle\Entity\Location;
use Stef\LocatieInformatieBundle\Entity\Municipality;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

class Correction {

    protected $slugifier;

    protected $municipalityManager;

    function __construct($municipalityManager)
    {
        $this->slugifier = new SlugManipulator();
        $this->municipalityManager = $municipalityManager;
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
        }

        return $location;
    }
}