<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\LocationTranslation")
 */
class Location
{
    /**
     * @var string
     *
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="locations")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="slug")
     */
    private $province;

    /**
     * @ORM\OneToMany(targetEntity="Hostel", mappedBy="location")
     */
    private $hostels;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="LocationImage", mappedBy="location")
     */
    private $images;

    /**
     * @ORM\OneToMany(
     *   targetEntity="LocationTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct() {
        $this->translations = new ArrayCollection();
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(OtherServicesTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Location
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getHostels()
    {
        return $this->hostels;
    }

    /**
     * @param mixed $hostels
     */
    public function setHostels($hostels)
    {
        $this->hostels = $hostels;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param Province $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    public function getAmountOfHostels() {
        return $this->getHostels()->count();
    }

    public function getFrontImage()
    {
        foreach ($this->getImages() as $image)
        {
            if($image->isFrontImage())
            {
                return $image;
            }
        }
        return null;
    }

    public function __toString() {
        return $this->name;
    }
}

