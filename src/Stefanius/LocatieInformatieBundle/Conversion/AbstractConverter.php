<?php
namespace Stefanius\LocatieInformatieBundle\Conversion;

use Stefanius\LocatieInformatieBundle\Entity\Location;
use Stefanius\LocatieInformatieBundle\Entity\Postcode;
use Stefanius\LocatieInformatieBundle\Manager\CityManager;
use Stefanius\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stefanius\LocatieInformatieBundle\Manager\PostcodeManager;
use Stefanius\LocatieInformatieBundle\Manager\ProvinceManager;
use Stefanius\LocatieInformatieBundle\Manager\StreetManager;
use Stefanius\LocatieInformatieBundle\Manager\ZipcodeManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

abstract class AbstractConverter
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
     * @param SlugManipulator $slugifier
     */
    function __construct(PostcodeManager $postcodeManager, ProvinceManager $provinceManager, MunicipalityManager $municipalityManager, CityManager $cityManager, ZipcodeManager $zipcodeManager, StreetManager $streetManager, SlugManipulator $slugifier)
    {
        $this->postcodeManager = $postcodeManager;
        $this->provinceManager = $provinceManager;
        $this->municipalityManager = $municipalityManager;
        $this->cityManager = $cityManager;
        $this->zipcodeManager = $zipcodeManager;
        $this->streetManager = $streetManager;
        $this->slugifier = $slugifier;
    }

    /**
     * @param Location $location
     * @param Postcode $postcode
     *
     * @return Location
     */
    protected function copyFields(Location $location, Postcode $postcode)
    {
        $location->setLat($postcode->getLat());
        $location->setLng($postcode->getLon());
        $location->setLocationDetail($postcode->getLocationDetail());
        $location->setRdX($postcode->getRdX());
        $location->setRdY($postcode->getRdY());
        $location->setCreated($postcode->getChangedDate());
        $location->setModified($postcode->getChangedDate());

        return $location;
    }

    public function convert($postcodeId)
    {
        if ($postcodeId == null) {
            return false;
        }

        if (!is_numeric($postcodeId)) {
            return false;
        }

        $postcode = $this->postcodeManager->getRepository()->findOneById($postcodeId);

        return $this->checkAndCreateNewLocation($postcode);
    }

    abstract protected function checkAndCreateNewLocation(Postcode $postcode);
}