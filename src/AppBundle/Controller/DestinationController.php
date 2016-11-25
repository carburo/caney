<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use AppBundle\Entity\Hostel;
use AppBundle\Form\HostelType;
use AppBundle\Repository\HostelRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DestinationController
 * @package AppBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class DestinationController extends Controller
{
    /**
     * @Route("/destination/{slug}", name="destinationView")
     */
    public function index(Request $request, Location $destination) {
        return $this->render('destination/index.html.twig', [
            'destination' => $destination
        ]);
    }
}
