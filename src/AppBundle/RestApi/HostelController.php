<?php

namespace AppBundle\RestApi;

use DateTime;
use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

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
        return $db->fetchAll("select * from hostel where slug = :slug", [
            "slug" => $slug
        ]);
    }

    public function getAvailabilityAction($id, $checkDate)
    {
        $db = $this->getConnection();
        $sql = "call hostel_availability(:id, :checkDate)";
        $dataset = $db->fetchAll($sql, [
            "id" => $id,
            "checkDate" => $checkDate
        ]);
        $result = [];
        foreach($dataset as $row) {
            $result[] = $row["available"] == "1";
        }
        return $result;
    }

    public function getImagesAction($slug, Request $request)
    {
        $repo = $this->getRepository();
        $helper = $this->get("vich_uploader.templating.helper.uploader_helper");
        $imagine = $this->get('liip_imagine.cache.manager');

        $hostel = $repo->findOneBySlug($slug);
        $images = $hostel->getImages();

        return ImageController::processImages($images, $request, $helper, $imagine);
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
