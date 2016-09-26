<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $locale = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        }

        $defaultLocale = $this->getParameter('locale');
        if($locale != null && strlen($locale) >= 2) {
            $locale = substr($locale, 0, 2);
            $allowedLocales = explode('|', $this->getParameter('app.locales'));
            if(!in_array($locale, $allowedLocales)) {
                $locale = $defaultLocale;
            }
        } else {
            $locale = $defaultLocale;
        }
        return $this->redirectToRoute('homepage', array(
            '_locale' => $locale,
        ));
    }

    /**
     * @Route("/{_locale}/", requirements={"_locale" = "%app.locales%"}, name="homepage")
     */
    public function homeAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Location');
        $locations = $repo->getBySortableGroups();
        $repo = $this->getDoctrine()->getRepository('AppBundle:Image');
        $recentPictures = $repo->findByFrontPage(true);
        return $this->render('home/index.html.twig', array(
            'locations' => $locations,
            'recentPictures' => $recentPictures,
        ));
    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {
        return $this->render("index.html.twig");
    }
}
