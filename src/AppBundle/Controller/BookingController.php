<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Entity\ContactMessage;
use AppBundle\Entity\Hostel;
use AppBundle\Form\BookingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $builder = $repo->createQueryBuilder('b');

        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $builder
                ->where('b.user = :user')
                ->setParameter(':user', $user)
                ;
        }

        // TODO Add a field in Booking with the date the booking was performed
        $bookings = $builder
            ->orderBy('b.bookingDatetime', 'DESC')
            ->getQuery()
            ->getResult()
        ;

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
        $this->denyAccessUnlessGranted('edit', $booking);

        $repo = $this->getDoctrine()->getRepository("AppBundle:ContactMessage");
        $messages = $repo->createQueryBuilder('m')
            ->where('m.thread = :thread')
            ->orderBy('m.messageDatetime', 'DESC')
            ->setParameter('thread', $booking->getCommentThread())
            ->getQuery()
            ->getResult()
        ;

        return $this->render('booking/details.html.twig', [
            'hostel' => $booking->getHostel(),
            'booking' => $booking,
            'messages' => $messages
        ]);
    }

    /**
     * @Route("/booking/cancel/{id}", name="booking_cancel")
     */
    public function bookingCancelAction(Request $request, Booking $booking) {
        $this->denyAccessUnlessGranted('edit', $booking);

        $booking->setStatus("CANCELLED");
        $this->saveInDatabase($booking);

        return $this->redirectToRoute('booking_details', ['id' => $booking->getId()]);
    }

    /**
     * @Route("/booking/confirm/{id}", name="booking_confirm")
     */
    public function bookingConfirmAction(Request $request, Booking $booking) {
        $this->denyAccessUnlessGranted('edit', $booking);

        $booking->setStatus("CONFIRMED");
        $this->saveInDatabase($booking);

        return $this->redirectToRoute('booking_details', ['id' => $booking->getId()]);
    }

    /**
     * @Route("/booking/confirm_available/{id}", name="booking_confirm_availability")
     */
    public function bookingConfirmAvailabilityAction(Request $request, Booking $booking) {
        $this->denyAccessUnlessGranted('admin', $booking);

        $booking->setStatus("PENDING_FOR_CONFIRMATION");
        $message = new ContactMessage();

        $message->setMessageDatetime(new \DateTime());
        $message->setUser($this->getUser());
        $message->setMessage($this->get('translator')->trans('booking.pending.confirmation.message'));
        $message->setThread($booking->getCommentThread());

        $booking->getCommentThread()->getMessages()->add($message);
        $this->saveInDatabase($booking);

        return $this->redirectToRoute('booking_details', ['id' => $booking->getId()]);
    }

    private function renderBookingForm(Request $request, Booking $booking, Hostel $hostel)  {
        $booking->setHostel($hostel);
        $booking->setUser($this->getUser());
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($hostel->getOfferType() != "SINGLE_ROOM" || sizeof($hostel->getRooms()) < 2) {
                $booking->setRooms($hostel->getRooms());
            }

            $this->sendEmail($booking);
            $this->saveInDatabase($booking);

            $message = new ContactMessage();
            $userManager = $this->get("fos_user.user_manager");
            $message->setUser($userManager->findUserByUsername("admin"));
            $message->setMessage($this->get('translator')->trans('booking.success.message'));
            $message->setMessageDatetime(new \DateTime());
            $message->setThread($booking->getCommentThread());
            $booking->getCommentThread()->getMessages()->add($message);

            $this->saveInDatabase($booking);
            $this->saveInDatabase($message);

            return $this->redirectToRoute('booking_details', ["id" => $booking->getId()]);
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
