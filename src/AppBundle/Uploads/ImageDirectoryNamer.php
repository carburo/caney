<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 15/06/16
 * Time: 11:37
 */

namespace AppBundle\Uploads;


use AppBundle\Entity\HostelImage;
use AppBundle\Entity\LocationImage;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class ImageDirectoryNamer implements  DirectoryNamerInterface {

    /**
     * Creates a directory name for the file being uploaded.
     *
     * @param object $object The object the upload is attached to.
     * @param PropertyMapping $mapping The mapping to use to manipulate the given object.
     *
     * @return string The directory name.
     */
    public function directoryName($object, PropertyMapping $mapping)
    {
        if($object instanceof HostelImage) {
            return "hostels/" . $object->getHostel()->getId();
        }
        if($object instanceof LocationImage) {
            return "locations/" . $object->getLocation()->getSlug();
        }
        return "general";
    }
}