<?php

namespace AppBundle\Controller;

use Doctrine\DBAL\Types\Type;
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
        $locationRepo = $this->getDoctrine()->getRepository('AppBundle:Location');
        $destinations = $locationRepo->activeLocations();

        $hostelRepo = $this->getDoctrine()->getRepository('AppBundle:Hostel');
        $hostels = $hostelRepo->findByActive(true);

        return $this->render('home/index.html.twig', [
            'destinations' => $destinations,
            'hostels' => $hostels,
            'destinationRepo' => $locationRepo,
        ]);
    }
}
