<?php

namespace Stefanius\LocatieInformatieBundle\Controller;

use Stefanius\SimpleCmsBundle\Entity\Page;

class StaticPageController extends BaseController
{
    public function locatieLokatieAction()
    {
        $page = new Page();

        $page->setTitle('Locatie of Lokatie');
        $page->setDescription('Schrijven wij Locatie of Lokatie? Wij hebben gekozen voor Locatie. Met een C dus. Lees hier waarom wij dat vinden!');
        $page->setBody($this->getLocatieText() . $this->getLocatieJumbotron());

        $page->setRobotsIndex(true);
        $page->setRobotsFollow(true);

        return $this->render('StefLocatieInformatieBundle:Page:show.html.twig', [
            'page' => $page
        ]);
    }

    public function provinceAction($provinceSlug = null)
    {
        $provinceManager = $this->getProvinceManager();
        $province = $provinceManager->read($provinceSlug);

        $page = new Page();
        $page->setRobotsIndex(true);
        $page->setRobotsFollow(true);

        if ($provinceSlug == null && $province == null) {
            $page->setTitle('Provincies in Nederland');
            $page->setDescription('Een volledig overzicht van Nederlandse provincies! Bekijk hier wat alle twaalf Nederlandse provincies kunnen bieden');
        } elseif ($provinceSlug != null && $province != null)  {
            $page->setTitle('Provincie ' . $province->getTitle());
            $page->setDescription('Bekijk hier alles over de provincie ' . $province->getTitle() . '! Met ' . count($province->getMunicipalities()) . ' gemeenten is er altijd wat te doen in ' . $province->getTitle());
        } else {
            return $this->redirect($this->generateUrl('stef_locatie_informatie_province_info_index'));
        }

        return $this->render('StefLocatieInformatieBundle:ProvinceInfo:show.html.twig', [
            'page' => $page,
            'province' => $province,
        ]);
    }

    /**
     * @return string
     */
    protected function getLocatieJumbotron()
    {
        return '<div class="jumbotron centered"><strong>Wat is juist: <em>locatie</em> of <em>lokatie</em>?</strong><p>	De juiste spelling is <em>locatie</em>, met een <em>c</em>.</p><p>Tot 2005 schreven sommige woordenboeken, waaronder Van Dale, <em>lokatie</em> met een <em>k</em>. Dat deden ze omdat woorden als <em>lokaal</em>, <em>lokaliseren</em> en <em>lokalisatie</em> ook met een <em>k</em> worden geschreven. Die keuze was gebaseerd op een belangrijk Nederlands spellingbeginsel: dat van de vormovereenkomst.</p><p>Maar ook het Groene Boekje baseert zich op vormovereenkomst; woorden die eindigen op [kaatsie] worden allemaal met <em>-catie</em> gespeld (<em>educatie</em>, <em>medicatie</em>, <em>specificatie</em>, enz.). Vandaar de keuze voor <em>locatie</em>. Die schrijfwijze is nu officieel en is door alle woordenboeken overgenomen. Ook het Witte Boekje geeft <em>locatie</em> met een <em>c</em>.</p><p>	In het Groene Boekje van 1995 stond overigens &eacute;&eacute;n woord dat op <em>-katie</em> eindigde: <em>predikatie</em>. Dat is in 2005 veranderd in <em>predicatie</em>.</p> <p><small><a href="https://onzetaal.nl/taaladvies/advies/locatie-lokatie">Bron: OnzeTaal.nl</a></small></p></div>';
    }

    /**
     * @return string
     */
    protected function getLocatieText()
    {
        $p1 = '<p>Het is een vraag die veel mensen bezig houd. Schrijven we LOCATIE nu met een K of LOKATIE met een C. Zelf hebben we hier ook onze twijfels over gehad. Immers, we willen wel dat mensen dit platform kunnen vinden en we willen ook geen flater slaan doordat we een domeinnaam hebben met een spelfoutje.</p>';
        $p2 = '<p>Gelukkig bestaan er woordenboeken en is er altijd het geliefde <strong><a href="https://onzetaal.nl/">Genootschap OnzeTaal</a></strong> waar iedereen zijn taaladviezen kan verkrijgen. Het onderbuikgevoel, dat wij een C verkiezen boven een K, lijkt juist te zijn. Of in elk geval, het Genootschap is het met ons eens.</p>';
        $p3 = '<h2>Citeren</h2><p>Hieronder citeren wij een stukje dat het Genootschap zegt over het gebruik van de C of de K in Lokatie (of Locatie natuurlijk). Wij nemen daarom aan de juiste keuze genomen te hebben met ons domein en ook de taalpuristen tevreden kunnen stellen.</p>';

        return $p1 . $p2 . $p3;
    }
}