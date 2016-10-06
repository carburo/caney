<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 5/10/16
 * Time: 19:04
 */

namespace AppBundle\RestApi;


use AppBundle\Entity\Booking;
use AppBundle\Form\BookingType;
use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction(Request $request)
    {
        $db = $this->getConnection();
        return $db->fetchAll("select * from booking");
    }

    public function getAction($id, Request $request)
    {
        $db = $this->getConnection();
        return $db->fetchAssoc("select * from booking where id = :id", [
            "id" => $id
        ]);
    }

    public function postAction(Booking $booking)
    {
        $repository = $this->getRepository();
        $em = $this->getDoctrine()->getManager();
        $statusCode = ($booking != null && $repository->findById($booking->getId())) ? 204 : 201;
        $form = $this->createForm(BookingType::class, $booking);

        if($form->isValid())
        {
            $em->persist($booking);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            if(201 == $statusCode)
            {
                $response->headers->set('Location',
                    $this->generateUrl('get_booking', ['id' => $booking->getId()], true)
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Booking');
    }
}