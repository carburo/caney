<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 5/10/16
 * Time: 19:04
 */

namespace AppBundle\RestApi;


use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction(Request $request)
    {
        $db = $this->getConnection();
        return $db->fetchAll("select * from booking");
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }
}