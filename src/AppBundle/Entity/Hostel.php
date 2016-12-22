<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Hostel
 *
 * @ORM\Table(name="hostel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HostelRepository")
 */
class Hostel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"hostelName"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="hostel_name", type="string", length=255)
     */
    private $hostelName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable = true)
     */
    private $description;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="price_in_high", type="decimal", precision=10, scale=2)
     */
    private $priceInHigh;

    /**
     * @var string
     *
     * @ORM\Column(name="price_in_low", type="decimal", precision=10, scale=2)
     */
    private $priceInLow;

    /**
     * @var string
     *
     * @ORM\Column(name="host_languages", type="string", length=255)
     */
    private $hostLanguages;

    /**
     * @ORM\OneToMany(targetEntity="Room", mappedBy="hostel")
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity="HostelImage", mappedBy="hostel")
     */
    private $images;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="offer_type", type="string", length=100)
     */
    private $offerType = "SINGLE_ROOM";

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @ORM\OneToMany(targetEntity="ServiceByHostel", mappedBy="hostel")
     */
    private $services;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="hostels")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="slug")
     */
    private $location;

    function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->images = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getHostelName()
    {
        return $this->hostelName;
    }

    /**
     * @param string $hostelName
     */
    public function setHostelName($hostelName)
    {
        $this->hostelName = $hostelName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Hostel
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Set hostLanguages
     *
     * @param string $hostLanguages
     *
     * @return Hostel
     */
    public function setHostLanguages($hostLanguages)
    {
        $this->hostLanguages = $hostLanguages;

        return $this;
    }

    /**
     * Get hostLanguages
     *
     * @return string
     */
    public function getHostLanguages()
    {
        return $this->hostLanguages;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
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

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getOfferType(): string
    {
        return $this->offerType;
    }

    /**
     * @param string $offerType
     */
    public function setOfferType(string $offerType)
    {
        $this->offerType = $offerType;
    }

    public function getCapacity()
    {
        $capacity = 0;
        foreach($this->getRooms() as $room) {
            $capacity += $room->getCapacity();
        }
        return $capacity;
    }

    /**
     * @return string
     */
    public function getPriceInHigh(): string
    {
        return $this->priceInHigh;
    }

    /**
     * @param string $priceInHigh
     */
    public function setPriceInHigh(string $priceInHigh)
    {
        $this->priceInHigh = $priceInHigh;
    }

    /**
     * @return string
     */
    public function getPriceInLow(): string
    {
        return $this->priceInLow;
    }

    /**
     * @param string $priceInLow
     */
    public function setPriceInLow(string $priceInLow)
    {
        $this->priceInLow = $priceInLow;
    }

    public function getMinimumPrice()
    {
        if($this->getOfferType() == "WHOLE_HOUSE") {
            return min($this->getPriceInHigh(), $this->getPriceInLow());
        }
        $roomPrice = 0;
        foreach ($this->getRooms() as $room) {
            if($roomPrice == 0 || $room->getPriceInLow() < $roomPrice) {
                $roomPrice = $room->getPriceinLow();
            }
        }
        return $roomPrice;
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

    /**
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * @return mixed
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param mixed $rooms
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
    }
    
    public function __toString() {
        return $this->hostelName;
    }
}


