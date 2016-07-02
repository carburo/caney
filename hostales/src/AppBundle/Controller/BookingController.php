<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Entity\Hostel;
use AppBundle\Form\BookingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookingController
 * @package AppBundle\Controller
 */
class BookingController extends Controller
{
    /**
     * @Route("/booking/{slug}", defaults={"slug" = "hostal-cabriales"}, name="booking")
     */
    public function bookingAction(Request $request, Hostel $hostel) {
        $booking = new Booking();
        if($this->isGranted('create', $booking)) {
            return $this->renderBookingForm($request, $booking, $hostel);
        } else {
            $request->getSession()->set('_security.main.target_path', 'booking');
            return $this->render('booking/index.html.twig', array(
                'not_access' => true,
                'hostel' => $hostel,
            ));
        }
    }

    private function renderBookingForm(Request $request, Booking $booking, Hostel $hostel)  {
        $booking->setHostel($hostel);
        $booking->setUser($this->getUser());
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->sendEmail($booking);
            $this->saveInDatabase($booking);

            if($request->isXmlHttpRequest()) {
                $status = array(
                    'type' => 'success',
                    'message' => $this->get('translator')->trans('booking.success.message')
                );
                return new JsonResponse($status);
            } else {
                unset($booking);
                unset($form);
                $booking = new Booking();
                $booking->setHostel($hostel);
                $form = $this->createForm(BookingType::class, $booking);
            }
        }

        return $this->render('booking/index.html.twig', array(
            'form' => $form->createView(),
            'hostel' => $hostel,
        ));
    }

    private function sendEmail(Booking $booking) {
        $message = \Swift_Message::newInstance()
            ->setSubject('Solicitud de reserva')
            ->setFrom($this->getParameter('sender.email'))
            ->setTo($this->getParameter('addressee.email'))
            ->setBody($this->renderView(
                'booking/mail.html.twig',
                array('booking' => $booking)
            ), 'text/html');
        $this->get('mailer')->send($message);
    }

    private function saveInDatabase($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }
}
