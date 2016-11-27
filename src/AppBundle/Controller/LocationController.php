<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DestinationController
 * @package AppBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class LocationController extends Controller
{
    /**
     * @Route("/destination/{slug}", name="destinationView")
     */
    public function index(Request $request, Location $destination) {
        $hostelRepo = $this->getDoctrine()->getRepository('AppBundle:Hostel');
        $hostels = $hostelRepo->activeByLocation($destination->getSlug());

        return $this->render('destination/index.html.twig', [
            'destination' => $destination,
            'hostels' => $hostels,
        ]);
    }
}
