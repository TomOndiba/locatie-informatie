<?php
namespace Stef\LocatieInformatieBundle\Conversion;

use Stef\LocatieInformatieBundle\Entity\Postcode;
use Stef\LocatieInformatieBundle\Entity\ZipCode;

class ZipcodeConverter extends AbstractConverter
{
    /**
     * Check and create a new ZipCode if its not existing
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

        $slug = $this->slugifier->manipulate(str_replace(' ', '', $postcode->getPostcode()));
        $entity = $this->zipcodeManager->getRepository()->findOneBySlug($slug);

        if ($entity != null) {
            return false;
        }

        /**
         * @var $z ZipCode
         */
        $z = $this->copyFields(new ZipCode(), $p);
        $z->setSlug($slug);
        $z->setSourceLocationTypeId($p->getPostcodeId());
        $z->setTitle($p->getPostcode());
        $z->setTitleLng($p->getPostcode());
        $z->setMinnumber($p->getMinnumber());
        $z->setMaxnumber($p->getMaxnumber());
        $z->setStreet($p->getStreet());
        $z->setNumbertype($p->getNumbertype());

        $z = $correction->correct($z, $p);

        $this->zipcodeManager->persistAndFlush($z);

        return true;
    }
}