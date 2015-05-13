<?php
namespace Stef\LocatieInformatieBundle\Conversion;

use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Postcode;

class CityConverter extends AbstractConverter
{
    /**
     * Check and create a new City if its not existing
     * @param Postcode $postcode
     *
     * @return bool
     */
    protected function checkAndCreateNewLocation(Postcode $postcode)
    {
        $correction = new Correction();
        $correction->setMunicipalityManager($this->municipalityManager);
        $correction->setZipCodeManager($this->zipcodeManager);
        $correction->setCityManager($this->cityManager);

        $slug = $this->slugifier->manipulate($postcode->getCity());
        $municipality = $this->municipalityManager->getRepository()->findOneByTitle($postcode->getMunicipality());

        $entity = $this->cityManager->getRepository()->findOneBy(['municipality' => $municipality, 'title' => $postcode->getCity()]);

        if ($entity != null) {
            return false;
        }

        $entity = $this->cityManager->getRepository()->findOneBySlug($slug);

        if ($entity != null) {
            $slug = $this->slugifier->manipulate($postcode->getCity() . '-' . $postcode->getProvinceCode());

            $entity = $this->cityManager->getRepository()->findOneBySlug($slug);

            if ($entity != null) {
                return false;
            }
        }

        /**
         * @var $c City
         */
        $c = $this->copyFields(new City(), $postcode);
        $c->setTitle($postcode->getCity());

        $c->setSlug($slug);
        $c->setSourceLocationTypeId($postcode->getCityId());

        $c = $correction->correct($c, $postcode);

        $this->cityManager->persistAndFlush($c);

        return true;
    }
}