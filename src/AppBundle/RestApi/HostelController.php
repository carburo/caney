<?php

namespace AppBundle\RestApi;

use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

class HostelController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction()
    {
        $db = $this->getConnection();
        return $db->fetchAll("select * from hostel");
    }

    public function getAction($slug)
    {
        $db = $this->getConnection();
        return $db->fetchAssoc("select * from hostel where slug = :slug", [
            "slug" => $slug
        ]);
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Hostel');
    }
}
