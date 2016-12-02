<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 5/10/16
 * Time: 18:43
 */

namespace AppBundle\RestApi;


use DateTime;
use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

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

    public function getAvailabilityAction($id)
    {
        $db = $this->getConnection();
        $sql = "call room_availability(:id, :checkDate)";
        $dataset = $db->fetchAll($sql, [
            "id" => $id,
            "checkDate" => (new DateTime())->format("y-m-d")
        ]);
        $result = [];
        foreach($dataset as $row) {
            $result[] = $row["available"] == "1";
        }
        return $result;
    }

    public function getImagesAction($slug, $id, Request $request)
    {
        $repo = $this->getRepository();
        $helper = $this->get("vich_uploader.templating.helper.uploader_helper");
        $imagine = $this->get('liip_imagine.cache.manager');

        $room = $repo->findOneById($id);
        $images = $room->getImages();

        return ImageController::processImages($images, $request, $helper, $imagine);
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Room');
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }
}