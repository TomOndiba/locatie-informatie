<?php
namespace Stef\LocatieInformatieBundle\Conversion;

use Stef\LocatieInformatieBundle\Entity\Municipality;
use Stef\LocatieInformatieBundle\Entity\Postcode;

class MunicipalityConverter extends AbstractConverter
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

        var_dump('PROVINCE CODE :: ' . $postcode->getProvinceCode());

        $province = $this->provinceManager->getRepository()->findOneByProvinceCode($postcode->getProvinceCode());

        if (null != $this->municipalityManager->getRepository()->findOneBy(['province' => $province, 'title' => $postcode->getMunicipality()])) {
            return false;
        }

        $slug = $this->slugifier->manipulate('gem-' . $postcode->getMunicipality() . '-' . $postcode->getProvinceCode());

        if (null != $this->municipalityManager->getRepository()->findOneBySlug($slug)) {
            return false;
        }

        /**
         * @var $m Municipality
         */
        $m = $this->copyFields(new Municipality(), $postcode);
        $m->setTitle($postcode->getMunicipality());

        $m->setSlug($slug);
        $m->setSourceLocationTypeId($postcode->getMunicipalityId());

        $m = $correction->correct($m, $postcode);

        if (null != $this->municipalityManager->getRepository()->findOneBy(['province' => $m->getProvince(), 'title' => $m->getTitle()])) {
            return false;
        }

        if (null != $this->municipalityManager->getRepository()->findOneBySlug($m->getSlug())) {
            return false;
        }

        $this->municipalityManager->persistAndFlush($m);

        return true;
    }
}