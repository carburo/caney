<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Entity\Hostel;
use AppBundle\Entity\User;
use AppBundle\Form\BookingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookingController
 * @package AppBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class BookingController extends Controller
{
    /**
     * @Route("/booking/list", name="user_bookings")
     */
    public function listAction(Request $request)
    {
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository("AppBundle:Booking");
        $bookings = $repo->findByUser($user);
        return $this->render('booking/list.html.twig', [
            'bookings' => $bookings
        ]);
    }

    /**
     * @Route("/booking/{slug}", name="booking")
     */
    public function bookingAction(Request $request, Hostel $hostel) {
        $booking = new Booking();
        if($this->isGranted('create', $booking)) {
            return $this->renderBookingForm($request, $booking, $hostel);
        } else {
            $request->getSession()->set('_security.main.target_path', 'booking');
            return $this->render('booking/index.html.twig', [
                'not_access' => true,
                'hostel' => $hostel,
            ]);
        }
    }

    /**
     * @Route("/booking/details/{id}", name="booking_details")
     */
    public function bookingDetailsAction(Request $request, Booking $booking) {
        // TODO set the appropriate permissions
        $accessGranted = $this->isGranted('create', $booking);
        if(!$accessGranted) {
            $request->getSession()->set('_security.main.target_path', 'booking_details');
        }
        return $this->render('booking/details.html.twig', [
            'not_access' => !$accessGranted,
            'hostel' => $booking->getHostel(),
            'booking' => $booking
        ]);
    }

    private function renderBookingForm(Request $request, Booking $booking, Hostel $hostel)  {
        $booking->setHostel($hostel);
        $booking->setUser($this->getUser());
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->sendEmail($booking);
            $booking->setStatus("PENDING");
            $this->saveInDatabase($booking);

            if($request->isXmlHttpRequest()) {
                $status = array(
                    'type' => 'success',
                    'message' => $this->get('translator')->trans('booking.success.message')
                );
                return new JsonResponse($status);
            } else {
                // return redirectToAction("hostel_view", ["hostel" => $hostel]);
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
