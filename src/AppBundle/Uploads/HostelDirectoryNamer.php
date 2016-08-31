<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 15/06/16
 * Time: 11:37
 */

namespace AppBundle\Uploads;


use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class HostelDirectoryNamer implements  DirectoryNamerInterface {

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
        return (string) $object->getHostel()->getId();
    }
}