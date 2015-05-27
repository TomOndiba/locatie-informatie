<?php

namespace Stef\LocatieInformatieBundle\Controller;

use Stef\LocatieInformatieBundle\Manager\LocationManager;
use Stef\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        $page = new Page();

        $page->setTitle('Locatie Informatie | Informatie over elke Locatie');

        return $this->render('StefLocatieInformatieBundle:Index:index.html.twig', [
            'page' => $page
        ]);
    }

    public function indexCitiesAction(Request $request, $char = null)
    {
        $manager = $this->getCityManager();
        $params = new ParameterBag();

        $params->set('pageTitleChar', 'Plaatsnamen in Nederland - Overzicht %CHAR%');
        $params->set('pageTitleNoChar', 'Plaatsen in Nederland');

        $params->set('pageDescriptionChar', '%NUMBER% plaatsen in Nederland met de letter %CHAR%. Bekijk hier ons overzicht Nederlandse plaatsen. Wij hebben er %NUMBER% verzameld! Bekijk hier ons overzicht met %NUMBER% plaatsen.');
        $params->set('pageDescriptionNoChar', 'Bekijk hier ons overzicht met Nederlandse plaatsen. Wij hebben %NUMBER% plaatsnamen in ons overzicht!');

        return $this->progressIndexPages($request, $manager, $char, $params);
    }

    public function indexMunicipalitiesAction(Request $request, $char = null)
    {
        $manager = $this->getMunicipalityManager();
        $params = new ParameterBag();

        $params->set('pageTitleChar', 'Gemeenten in Nederland - Overzicht %CHAR%');
        $params->set('pageTitleNoChar', 'Gemeenten in Nederland');

        $params->set('pageDescriptionChar', '%NUMBER% Nederlandse gemeenten in met de letter %CHAR%. Wij hebben gemeenten %NUMBER% verzameld! Bekijk hier ons overzicht met %NUMBER% gemeenten met de letter %CHAR%.');
        $params->set('pageDescriptionNoChar', 'Bekijk hier ons overzicht met Nederlandse gemeenten. Wij hebben %NUMBER% gemeenten in ons overzicht!');

        return $this->progressIndexPages($request, $manager, $char, $params);
    }

    public function indexMunicipalitiesByProvinceAction(Request $request, $provinceSlug = null)
    {
        $provinceManager = $this->getProvinceManager();
        $municipalityManager = $this->getMunicipalityManager();

        $province = $provinceManager->read($provinceSlug);
        $municipalities = $municipalityManager->findByProvince($province);

        $page = new Page();
        if ($province == null) {
            $page->setTitle('Overzicht Nederlandse gemeenten per Provincie');
            $page->setDescription('Bekijk hier het volledige overzicht van alle Nederlandse gemeenten! Wij hebben het overzicht gesplitst per provincie.');
        } else {
            $page->setTitle('Nederlandse gemeenten in ' . $province->getTitle());
            $page->setDescription('Bekijk hier het overzicht van ' . count($municipalities) . ' Nederlandse gemeenten uit de provincie ' . $province->getTitle() . '! Of kijk naar een ander overzicht als je niet op zoek bent naar ' . $province->getTitle());
        }

        $page->setRobotsIndex(false);

        if (count($municipalities) > 50) {
            $page->setRobotsIndex(true);
        }

        return $this->render('StefLocatieInformatieBundle:IndexPages:list.html.twig', [
            'items' => $municipalities,
            'province' => $province,
            'type' => 'province',
            'page' => $page,
        ]);
    }

    public function indexProvincesAction(Request $request, $char = null)
    {
        $manager = $this->getProvinceManager();
        $params = new ParameterBag();

        $params->set('pageTitleChar', 'Provincies in Nederland - Overzicht %CHAR%');
        $params->set('pageTitleNoChar', 'Provincies in Nederland');

        $params->set('pageDescriptionChar', '%NUMBER% provincies in Nederland beginnen met de letter %CHAR%! Uiteraard kennen wij alle twaalf provincies op ons duimpje.');
        $params->set('pageDescriptionNoChar', 'Bekijk hier ons overzicht met Nederlandse provincies. Ontdek alle twaalf de Nederlandse provincies vandaag nog!');

        return $this->progressIndexPages($request, $manager, $char, $params);
    }

    protected function progressIndexPages(Request $request, LocationManager $manager, $char = null, ParameterBag $params)
    {
        if ($char == null) {
            return $this->redirect($this->generateUrl($request->get('_route') . '_by_char', ['char' => $params->get('redirectNullTo', 'a')]));
        }

        if ($char != null && !(strlen($char) === 1 || $char === 'apostrof')) {
            return $this->redirect($this->generateUrl($request->get('_route'), ['char' => $params->get('redirectTo', 'a')]));
        }

        $list = $manager->getListByFirstLetter($char);

        $page = new Page();

        if ($char == null) {
            $page->setTitle($params->get('pageTitleNoChar'));
            $page->setDescription($params->get('pageDescriptionNoChar'));
        } else {
            $page->setTitle($params->get('pageTitleChar'));
            $page->setDescription($params->get('pageDescriptionChar'));
        }

        $page->setDescription(str_replace(['%NUMBER%', '%CHAR%'], [count($list), strtoupper($char)], $page->getDescription()));
        $page->setTitle(str_replace(['%NUMBER%', '%CHAR%'], [count($list), strtoupper($char)], $page->getTitle()));
        $page->setRobotsIndex(false);

        if (count($list) > 75) {
            $page->setRobotsIndex(true);
        }

        return $this->render('StefLocatieInformatieBundle:IndexPages:list.html.twig', [
            'items' => $list,
            'char' => $char,
            'route' => $request->get('_route'),
            'type' => 'char',
            'page' => $page,
        ]);
    }
}