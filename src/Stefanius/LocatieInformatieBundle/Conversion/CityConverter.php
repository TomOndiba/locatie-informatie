<?php
namespace Stefanius\LocatieInformatieBundle\Conversion;

use Stefanius\LocatieInformatieBundle\Entity\City;
use Stefanius\LocatieInformatieBundle\Entity\Postcode;

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
        $correction->setProvinceManager($this->provinceManager);

        if ($postcode->getCity() === 'Geffen' && $postcode->getProvinceCode() === 'NB') {
            $postcode->setMunicipality('Oss');
        } else if (($postcode->getCity() === 'Vinkel' || $postcode->getCity() === 'Nuland') && $postcode->getProvinceCode() === 'NB') {
            $postcode->setMunicipality('\'s‑Hertogenbosch');
        }

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
        $c->setMunicipality($municipality);

        $c = $correction->correct($c, $postcode);

        if ($municipality != null) {
            $this->cityManager->persistAndFlush($c);
        } else {
            return false;
        }

        return true;
    }
}