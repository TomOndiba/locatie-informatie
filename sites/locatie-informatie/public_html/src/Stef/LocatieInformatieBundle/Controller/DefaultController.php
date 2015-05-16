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

        return $this->render('StefLocatieInformatieBundle:Index:index.html.twig', [
            'page' => $page
        ]);
    }

    public function indexCitiesAction(Request $request, $char = null)
    {
        $manager = $this->getCityManager();
        $params = new ParameterBag();

        return $this->progressIndexPages($request, $manager, $char, $params);
    }

    public function indexMunicipalitiesAction(Request $request, $char = null)
    {
        $manager = $this->getMunicipalityManager();
        $params = new ParameterBag();

        return $this->progressIndexPages($request, $manager, $char, $params);
    }

    public function indexProvincesAction(Request $request, $char = null)
    {
        $manager = $this->getProvinceManager();
        $params = new ParameterBag();

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
        $page->setRobotsIndex(false);

        return $this->render('StefLocatieInformatieBundle:IndexPages:list.html.twig', [
            'items' => $list,
            'char' => $char,
            'route' => $request->get('_route'),
            'page' => $page,
        ]);
    }
}