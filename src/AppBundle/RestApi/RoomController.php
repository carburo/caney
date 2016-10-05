<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 5/10/16
 * Time: 18:43
 */

namespace AppBundle\RestApi;


use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

class RoomController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction($slug)
    {
        $db = $this->getConnection();
        $sql = "select * from room where hostel_id = (select id from hostel where slug = :slug)";
        return $db->fetchAll($sql, [
            "slug" => $slug
        ]);
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }
}