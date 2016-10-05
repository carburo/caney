<?php

namespace AppBundle\RestApi;

use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class ProvinceController extends FOSRestController implements ClassResourceInterface
{

    public function cgetAction(Request $request)
    {
        $db = $this->getConnection();
        return $db->fetchAll("select * from province order by position");
    }

    public function getAction($slug, Request $request)
    {
        $db = $this->getConnection();
        return $db->fetchAssoc("select * from province where slug = :slug", [
           'slug' => $slug
        ]);
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }
}
