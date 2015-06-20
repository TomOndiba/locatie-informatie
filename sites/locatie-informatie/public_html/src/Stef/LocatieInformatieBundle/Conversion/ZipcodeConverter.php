<?php
namespace Stef\LocatieInformatieBundle\Conversion;

use Stef\LocatieInformatieBundle\Entity\Postcode;
use Stef\LocatieInformatieBundle\Entity\Street;
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
            $z = $this->copyFields($entity, $postcode);
        } else {
            $z = $this->copyFields(new ZipCode(), $postcode);
        }

        /**
         * @var $z ZipCode
         */
        $z->setSlug($slug);
        $z->setSourceLocationTypeId($postcode->getPostcodeId());
        $z->setTitle($postcode->getPostcode());
        $z->setTitleLng($postcode->getPostcode());
        $z->setMinnumber($postcode->getMinnumber());
        $z->setMaxnumber($postcode->getMaxnumber());
        $z->setNumbertype($postcode->getNumbertype());
        $z->setStreet($postcode->getStreet());

        $z = $correction->correct($z, $postcode);
        $this->zipcodeManager->persist($z);

        /*
        $street = $this->streetManager->findByCityAndName($z->getCity(), $postcode->getStreet());

        if ($street === null) {
            $street = new Street();
        }

        $street->setCity($z->getCity());
        $street->setTitle($postcode->getStreet());
        $street->setLng($postcode->getLon());
        $street->setLat($postcode->getLat());

        if ($street->getMaxnumber() === null || $postcode->getMaxnumber() >= $street->getMaxnumber()) {
            $street->setMaxnumber($postcode->getMaxnumber());
        }

        if ($street->getMinnumber() === null || $postcode->getMinnumber() >= $street->getMinnumber()) {
            $street->setMinnumber($postcode->getMinnumber());
        }

        if ($street->getNumbertype() === null || empty($street->getNumbertype() )) {
            $street->setNumbertype($postcode->getNumbertype());
        } else if ($street->getNumbertype() !== $postcode->getNumbertype()) {
            $street->setNumbertype('mixed');
        } else {
            $street->setNumbertype('need-fix');
        }

        $street->addZipCode($z);
        $this->streetManager->persistAndFlush($street);
        $z->setStreet($street);
        */
        $this->zipcodeManager->persistAndFlush($z);

        return true;
    }
}