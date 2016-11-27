<?php

namespace AppBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LocationImage
 *
 * @ORM\Table(name="location_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationImageRepository")
 * @Vich\Uploadable
 */
class LocationImage extends Image
{
    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="images")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="slug")
     */
    private $location;

    /**
     * @var bool
     *
     * @ORM\Column(name="front_image", type="boolean")
     */
    private $frontImage;

    public function __construct(CacheManager $cacheManager = null)
    {
        parent::__construct($cacheManager);
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return boolean
     */
    public function isFrontImage(): bool
    {
        return $this->frontImage;
    }

    /**
     * @param boolean $frontImage
     */
    public function setFrontImage(bool $frontImage)
    {
        $this->frontImage = $frontImage;
    }
}

