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
 * Class HostelController
 * @package AppBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class HostelController extends Controller
{
    /**
     * @Route("/hostels/{slug}", name="hostelsByDestination")
     */
    public function galleryByDestinationAction(Request $request, Location $destination) {
        return $this->hostelGallery($destination->getHostels(), $destination->getName());
    }

    /**
     * @Route("/hostels", name="hostels")
     */
    public function galleryAction(Request $request) {
        $repo = $this->getRepository();
        if($request->query->has('query')) {
            $query = $request->query->get('query');
            $hostels = $repo->search($query);
        } else {
            $query = "";
            $hostels = $repo->findAll();
        }
        return $this->hostelGallery($hostels, $query);
    }

    private function hostelGallery($hostels, $query = "") {
        return $this->render('hostel/gallery.html.twig', [
            'hostels' => $hostels,
            'query' => $query
        ]);
    }

    /**
     * @Route("/hostels_row/{location}/{id}", name="hostels_row", defaults={"id" = 0})
     */
    public function rowAction(Location $location, $id = 0) {
        $repo = $this->getRepository();
        $hostels = $repo->findByLocation($location->getSlug(), $id, 8);

        return $this->render('hostel/hostels_row.html.twig', [
            'hostels' => $hostels
        ]);
    }

    /**
     * @Route("/hostel/search", name="hostel_search", options={"expose"=true})
     */
    public function searchAction(Request $request) {
        $repo = $this->getRepository();
        $query = $request->query->get('query');
        $hostels = $repo->search($query);

        return $this->render('hostel/gallery_content.html.twig', [
            'hostels' => $hostels
        ]);
    }

    /**
     * @Route("/hostel/register", name="hostel_registration")
     */
    public function registerAction(Request $request)
    {
        $hostel = new Hostel();

        $this->denyAccessUnlessGranted('create', $hostel);

        $hostel->setOwner($this->getUser());
        $hostel->setActive(false);

        $form = $this->createForm(HostelType::class, $hostel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveInDatabase($hostel);
            return $this->redirectToRoute('hostel_edit', ['slug' => $hostel->getSlug()]);
        }

        return $this->render('hostel/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/hostel/edit/{slug}", name="hostel_edit")
     */
    public function editAction(Request $request, Hostel $hostel)
    {
        $this->denyAccessUnlessGranted('edit', $hostel);
        $form = $this->createForm(HostelType::class, $hostel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveInDatabase($hostel);
            return $this->redirectToRoute('hostel_view', ['slug' => $hostel->getSlug()]);
        }

        return $this->render('hostel/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/rooms/edit/{slug}", name="hostel_rooms_edit")
     */
    public function editRoomsAction(Request $request, Hostel $hostel)
    {
        $this->denyAccessUnlessGranted('edit', $hostel);

        return $this->render('hostel/edit_rooms.html.twig', [
            'rooms' => $hostel->getRooms(),
            'hostel' => $hostel
        ]);
    }

    /**
     * @Route("/hostel/{slug}", name="hostel_view")
     */
    public function viewAction(Request $request, Hostel $hostel) {
        $edit = false;
        if($this->isGranted('edit', $hostel)) {
            $edit = true;
        }
        return $this->render('hostel/view.html.twig', [
            'hostel' => $hostel,
            'edit' => $edit
        ]);
    }

    private function saveInDatabase($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }

    public function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Hostel');
    }
}
