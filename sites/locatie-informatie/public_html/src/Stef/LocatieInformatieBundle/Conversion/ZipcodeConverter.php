<?php
namespace Stef\LocatieInformatieBundle\Conversion;

use Doctrine\ORM\QueryBuilder;
use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Postcode;
use Stef\LocatieInformatieBundle\Entity\ZipCode;
use Stef\LocatieInformatieBundle\Manager\CityManager;
use Stef\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stef\LocatieInformatieBundle\Manager\PostcodeManager;
use Stef\LocatieInformatieBundle\Manager\ZipcodeManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

class ZipcodeConverter extends AbstractConverter
{
    /**
     * @var PostcodeManager
     */
    protected $postcodeManager;

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
     * @var SlugManipulator
     */
    protected $slugifier;

    function __construct(PostcodeManager $postcodeManager, MunicipalityManager $municipalityManager, CityManager $cityManager, ZipcodeManager $zipcodeManager, SlugManipulator $slugifier)
    {
        $this->postcodeManager = $postcodeManager;
        $this->municipalityManager = $municipalityManager;
        $this->cityManager = $cityManager;
        $this->zipcodeManager = $zipcodeManager;
        $this->slugifier = $slugifier;
    }

    public function convert()
    {
        $limit = 500;

        for($page = 0; $page < 10; $page++) {
            var_dump('**********NEXT 50****    -     ' . $page);
            $entities = $this->postcodeManager->getRepository()->findBy([], [], $limit, ($page * $limit));
            $this->doStuff($entities);

        }

    }

    protected function doStuff($entities)
    {
        $correction = new Correction();
        $correction->setMunicipalityManager($this->municipalityManager);
        $correction->setZipCodeManager($this->zipcodeManager);
        $correction->setCityManager($this->cityManager);

        /**
         * @var $p Postcode
         */
        foreach ($entities as $p) {
            $slug = $this->slugifier->manipulate(str_replace(' ', '', $p->getPostcode()));
            $entity = $this->zipcodeManager->getRepository()->findOneBySlug($slug);

            if ($entity != null) {
                continue;
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
        }
    }
}