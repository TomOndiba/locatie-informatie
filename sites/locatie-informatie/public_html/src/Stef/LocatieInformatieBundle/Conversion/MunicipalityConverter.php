<?php
namespace Stef\LocatieInformatieBundle\Conversion;

use Doctrine\ORM\QueryBuilder;
use Stef\LocatieInformatieBundle\Entity\Municipality;
use Stef\LocatieInformatieBundle\Entity\Postcode;
use Stef\LocatieInformatieBundle\Manager\MunicipalityManager;
use Stef\LocatieInformatieBundle\Manager\PostcodeManager;
use Stef\SlugManipulation\Manipulators\SlugManipulator;

class MunicipalityConverter
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
     * @var SlugManipulator
     */
    protected $slugifier;

    function __construct(PostcodeManager $postcodeManager, MunicipalityManager $municipalityManager, SlugManipulator $slugifier)
    {
        $this->postcodeManager = $postcodeManager;
        $this->municipalityManager = $municipalityManager;
        $this->slugifier = $slugifier;
    }

    public function convert()
    {
        /**
         * @var $qbPostcode QueryBuilder
         */
        $qbPostcode = $this->postcodeManager->getRepository()->createQueryBuilder('p');

        $this->doStuff($qbPostcode->select('p')->groupBy('p.municipality')->getQuery()->getResult(), 'municipality');
        $this->doStuff($qbPostcode->select('p')->groupBy('p.municipalityId')->getQuery()->getResult(), 'id');
    }

    protected function doStuff($entities, $type)
    {
        /**
         * @var $p Postcode
         */
        foreach ($entities as $p) {
            if ($type === 'id') {
                $entity = $this->municipalityManager->getRepository()->findOneBySourceLocationTypeId($p->getMunicipalityId());
            } else {
                $entity = $this->municipalityManager->getRepository()->findOneByTitle($p->getMunicipality());
            }

            if ($entity != null) {
                continue;
            }

            $slug = $this->slugifier->manipulate($p->getMunicipality());

            $entity = $this->municipalityManager->getRepository()->findOneBySlug($slug);

            if ($entity != null) {
                $slug = $this->slugifier->manipulate($p->getMunicipality() . '-' . $p->getProvinceCode());

                $entity = $this->municipalityManager->getRepository()->findOneBySlug($slug);

                if ($entity != null) {
                    continue;
                }
            }


            $m = new Municipality();
            $m->setTitle($p->getMunicipality());
            $m->setLat($p->getLat());
            $m->setLng($p->getLon());
            $m->setLocationDetail($p->getLocationDetail());
            $m->setRdX($p->getRdX());
            $m->setRdY($p->getRdY());
            $m->setSlug($slug);
            $m->setSourceLocationTypeId($p->getMunicipalityId());
            $m->setProvinceCode($p->getProvinceCode());
            $m->setCreated($p->getChangedDate());
            $m->setModified($p->getChangedDate());

            $this->postcodeManager->persistAndFlush($m);
        }
    }
}