<?php
namespace Stef\LocatieInformatieBundle\Conversion;

use Doctrine\ORM\QueryBuilder;
use Stef\LocatieInformatieBundle\Entity\City;
use Stef\LocatieInformatieBundle\Entity\Postcode;
use Stef\LocatieInformatieBundle\Manager\CityManager;
use Stef\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stef\LocatieInformatieBundle\Manager\PostcodeManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

class CityConverter extends AbstractConverter
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
     * @var SlugManipulator
     */
    protected $slugifier;

    function __construct(PostcodeManager $postcodeManager, MunicipalityManager $municipalityManager, CityManager $cityManager,SlugManipulator $slugifier)
    {
        $this->postcodeManager = $postcodeManager;
        $this->municipalityManager = $municipalityManager;
        $this->cityManager = $cityManager;
        $this->slugifier = $slugifier;
    }

    public function convert()
    {
        /**
         * @var $qbPostcode QueryBuilder
         */
        $qbPostcode = $this->postcodeManager->getRepository()->createQueryBuilder('p');

        $this->doStuff($qbPostcode->select('p')->groupBy('p.city')->getQuery()->getResult(), 'city');
        $this->doStuff($qbPostcode->select('p')->groupBy('p.cityId')->getQuery()->getResult(), 'id');
    }

    protected function doStuff($entities, $type)
    {
        $correction = new Correction($this->municipalityManager);

        /**
         * @var $p Postcode
         */
        foreach ($entities as $p) {
            if ($type === 'id') {
                $entity = $this->cityManager->getRepository()->findOneBySourceLocationTypeId($p->getCityId());
            } else {
                $entity = $this->cityManager->getRepository()->findOneByTitle($p->getCity());
            }

            if ($entity != null) {
                continue;
            }

            $slug = $this->slugifier->manipulate($p->getCity());
            var_dump($p->getCity() . '   -    ' . $slug . '   -   ' . $p->getId());
            $entity = $this->cityManager->getRepository()->findOneBySlug($slug);

            if ($entity != null) {
                $slug = $this->slugifier->manipulate($p->getCity() . '-' . $p->getProvinceCode());

                $entity = $this->cityManager->getRepository()->findOneBySlug($slug);

                if ($entity != null) {
                    continue;
                }
            }

            /**
             * @var $c City
             */
            $c = $this->copyFields(new City(), $p);
            $c->setTitle($p->getCity());

            $c->setSlug($slug);
            $c->setSourceLocationTypeId($p->getCityId());

            $c = $correction->correct($c, $p);

            $this->cityManager->persistAndFlush($c);
        }
    }
}