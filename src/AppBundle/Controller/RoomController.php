<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hostel;
use AppBundle\Entity\Room;
use AppBundle\Form\RoomType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RoomController
 * @package AppBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class RoomController extends Controller
{
    /**
     * @Route("/room/{id}", name="room_view")
     */
    public function viewAction(Request $request, Room $room) {
        return $this->render('room/view.html.twig', [
            'room' => $room
        ]);
    }

    /**
     * @Route("/room/edit/{id}", name="room_edit")
     */
    public function editAction(Request $request, Room $room)
    {
        $this->denyAccessUnlessGranted('edit', $room->getHostel());
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveInDatabase($room);
        }

        return $this->render('room/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function saveInDatabase($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }

    public function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Room');
    }
}
