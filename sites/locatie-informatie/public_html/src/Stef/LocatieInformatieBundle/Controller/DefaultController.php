<?php

namespace Stef\LocatieInformatieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StefLocatieInformatieBundle:Default:index.html.twig', array('name' => $name));
    }
}
