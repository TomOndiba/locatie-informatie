<?php

namespace Stef\LocatieInformatieBundle\Controller;

use Stefanius\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class MunicipalityController extends BaseController
{
    public function showAction(Request $request, $slug)
    {
        $manager = $this->getMunicipalityManager();

        $municipality = $manager->findOneBySlug($slug);

        $page = new Page();
        $page->setTitle($municipality->getTitleLng());
        $page->setDescription($municipality->getTitleLng() . ' is een van de gemeenten in de provincie ' . $municipality->getProvince()->getTitle());

        return $this->render('StefLocatieInformatieBundle:Municipality:show.html.twig', [
            'municipality' => $municipality,
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