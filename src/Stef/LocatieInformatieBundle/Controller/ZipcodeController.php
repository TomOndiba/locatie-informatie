<?php

namespace Stef\LocatieInformatieBundle\Controller;

use Stefanius\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class ZipcodeController extends BaseController
{
    public function redirectAction(Request $request, $pnum, $pchar)
    {
        return $this->redirect($this->generateUrl('stef_locatie_informatie_zipcode_info', ['pnum' => $pnum, 'pchar' => strtolower($pchar)]));
    }

    public function showAction(Request $request, $pnum, $pchar)
    {
        $manager = $this->getZipcodeManager();

        $zipcode =  $manager->findOneBySlug($pnum . $pchar);

        $page = new Page();
        $page->setTitle('Postcode ' . $zipcode->getPnum() . ' ' . strtoupper($zipcode->getPchar()) . ' (' . $zipcode->getCity()->getTitle() . ')');
        $page->setDescription('Lees hier alle locatie informatie die wij hebben over postcode ' . $zipcode->getPnum() . ' ' . strtoupper($zipcode->getPchar()) . '. Deze mooie postcode vinden we in de ' . $zipcode->getStreet() .' in ' . $zipcode->getCity()->getTitle() . '.');

        return $this->render('StefLocatieInformatieBundle:Zipcode:show.html.twig', [
            'zipcode' => $zipcode,
            'page' => $page
        ]);
    }

    public function showareaAction(Request $request, $pnum)
    {
        $manager = $this->getZipcodeManager();

        $zipcodes =  $manager->findByPnum($pnum);
        $zipcode = $zipcodes[0];

        $page = new Page();
        $page->setTitle('Postcode ' . $zipcode->getPnum() . ' (' . $zipcode->getCity()->getMunicipality()->getTitleLng() . ')');
        $page->setDescription('Wij hebben ons best gedaan om alles over postcodegebied ' . $pnum . ' te verzamelen. Lees hier snel meer over postodes in ' . $zipcode->getCity()->getTitle() . '.');

        return $this->render('StefLocatieInformatieBundle:Zipcode:showarea.html.twig', [
            'zipcode' => $zipcode,
            'zipcodes' => $zipcodes,
            'page' => $page
        ]);
    }

    public function indexAction(Request $request)
    {
        $manager = $this->getZipcodeManager();
        $zipcodes = [];
        $letters = range('a', 'z');

        foreach ($letters as $letter) {
            $zipcodes =  array_merge($zipcodes, $manager->findByPchar(strtoupper($letter . $letter)));
        }

        ksort($zipcodes);

        $page = new Page();
        $page->setTitle('Overzicht Nederlandse postcodes');
        $page->setDescription('Bekijk hier ons volledige overzicht van postcodes! Wij hebben ons best gedaan om er zoveel mogelijk te verzamelen!');

        return $this->render('StefLocatieInformatieBundle:Zipcode:index.html.twig', [
            'zipcodes' => $zipcodes,
            'page' => $page
        ]);
    }
}