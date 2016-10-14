<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 6/10/16
 * Time: 1:20
 */

namespace AppBundle\RestApi;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageController extends FOSRestController implements ClassResourceInterface
{

    public function getAction($id, Request $request)
    {
        $repo = $this->getRepository();
        $helper = $this->get("vich_uploader.templating.helper.uploader_helper");
        $image = $repo->findOneById($id);
        return self::processImage($image, $request, $helper);
    }

    public static function processImages($images, Request $request, UploaderHelper $helper, $imagine)
    {
        $data = [];
        foreach ($images as $image)
        {
            $data [] = self::processImage($image, $request, $helper, $imagine);
        }
        return $data;
    }

    public static function processImage($image, Request $request, UploaderHelper $helper, $imagine)
    {
        $imagePath = $helper->asset($image, 'imageFile');
        return [
            "id" => $image->getId(),
            //"uri" => $request->getUriForPath($imagePath),
            "uri" => $imagine->getBrowserPath($imagePath, "app_image"),
            "uri_thumb" => $imagine->getBrowserPath($imagePath, "app_thumb"),
            "pixelWidth" => $image->getPixelWidth(),
            "pixelHeight" => $image->getPixelHeight(),
            "description" => $image->getDescription(),
            "part_of_the_house" => $image->getPartOfTheHouse()->getName()
        ];
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:HostelImage');
    }

    private function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }

}