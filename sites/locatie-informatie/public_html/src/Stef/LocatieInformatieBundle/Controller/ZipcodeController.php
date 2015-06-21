<?php

namespace Stef\LocatieInformatieBundle\Controller;

use Stef\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class ZipcodeController extends BaseController
{
    public function redirectAction(Request $request, $pnum, $pchar)
    {
        return $this->redirect($this->generateUrl('stef_locatie_informatie_zipcode_info', ['pnum' => $pnum, 'pchar' => strtolower($pchar)]));
    }

    public function infoAction(Request $request, $pnum, $pchar)
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
}