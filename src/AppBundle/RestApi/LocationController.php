<?php

namespace AppBundle\RestApi;

use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction(Request $request)
    {
        $db = $this->getConnection();
        $sql = $this->sqlSelect;
        return $db->fetchAll("$sql order by position", ["locale" => $request->getLocale()]);
    }

    public function getAction($slug, Request $request)
    {
        $db = $this->getConnection();
        $sql = "$this->sqlSelect where slug = :slug";

        return $db->fetchAssoc($sql, [
            "slug" => $slug,
            "locale" => $request->getLocale()
        ]);
    }

    public function getHostelsAction($slug)
    {
        $db = $this->getConnection();
        return $db->fetchAll("select * from hostel where location_id = :slug", [
            "slug" => $slug
        ]);
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Location');
    }

    private $sqlSelect = "
            SELECT
                slug,
                COALESCE (t.content, NAME) name,
                position,
                province_id
            FROM
                location l
            LEFT OUTER JOIN location_translations t ON (t.object_id, t.locale) = (l.slug, :locale)
        ";
}
