<?php

namespace AppBundle\RestApi;

use AppBundle\Entity\Hostel;
use Doctrine\DBAL\Connection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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

    private $imagesSql = "
        SELECT
            filename,
            description
        FROM
            image i
        JOIN hostel_image hi ON i.id = hi.id
        WHERE
            hi.hostel_id = (select id from hostel where slug = :slug)
    ";
}
