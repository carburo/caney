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
     * @ORM\Column(name="host_languages", type="string", length=255)
     */
    private $hostLanguages;

    /**
     * @var bool
     *
     * @ORM\Column(name="breakfast", type="boolean")
     */
    private $breakfast;
    
    /**
     * @var string
     *
     * @ORM\Column(name="breakfast_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $breakfastPrice;

    /**
     * @var bool
     *
     * @ORM\Column(name="dinner", type="boolean")
     */
    private $dinner;

    /**
     * @var string
     *
     * @ORM\Column(name="dinner_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $dinnerPrice;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="cocktails", type="boolean")
     */
    private $cocktails;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="children", type="boolean")
     */
    private $childrenAccepted;

    /**
     * @var bool
     *
     * @ORM\Column(name="garage", type="boolean")
     */
    private $garage;
    
    /**
     * @var string
     *
     * @ORM\Column(name="garage_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $garagePrice;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="swimming_pool", type="boolean")
     */
    private $swimmingPool;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="laundry", type="boolean")
     */
    private $laundry;

    /**
     * @var bool
     *
     * @ORM\Column(name="guide", type="boolean")
     */
    private $guide;

    /**
     * @var bool
     *
     * @ORM\Column(name="horse_ride", type="boolean")
     */
    private $horseRide;

    /**
     * @var bool
     *
     * @ORM\Column(name="scuba_diving", type="boolean")
     */
    private $scubaDiving;

    /**
     * @var bool
     *
     * @ORM\Column(name="internet", type="boolean")
     */
    private $internet;

    /**
     * @var bool
     *
     * @ORM\Column(name="wifi", type="boolean")
     */
    private $wifi;

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

//    /**
//     *
//     * @ORM\ManyToMany(targetEntity="OtherServices")
//     * @ORM\JoinTable(name="services_by_hostel",
//     *      joinColumns={@ORM\JoinColumn(name="hostel_id", referencedColumnName="id")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id")}
//     *      )
//     */
//    private $otherServices;

//    /**
//     *
//     * @ORM\ManyToMany(targetEntity="Service")
//     * @ORM\JoinTable(name="service_by_hostel",
//     *      joinColumns={@ORM\JoinColumn(name="hostel_id", referencedColumnName="id")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id")}
//     *      )
//     */
//    private $services;

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
     * Set breakfastPrice
     *
     * @param string $breakfastPrice
     *
     * @return Hostel
     */
    public function setBreakfastPrice($breakfastPrice)
    {
        $this->breakfastPrice = $breakfastPrice;

        return $this;
    }

    /**
     * Get breakfastPrice
     *
     * @return string
     */
    public function getBreakfastPrice()
    {
        return $this->breakfastPrice;
    }

    /**
     * Set dinnerPrice
     *
     * @param string $dinnerPrice
     *
     * @return Hostel
     */
    public function setDinnerPrice($dinnerPrice)
    {
        $this->dinnerPrice = $dinnerPrice;

        return $this;
    }

    /**
     * Get dinnerPrice
     *
     * @return string
     */
    public function getDinnerPrice()
    {
        return $this->dinnerPrice;
    }

    /**
     * Set internet
     *
     * @param boolean $internet
     *
     * @return Hostel
     */
    public function setInternet($internet)
    {
        $this->internet = $internet;

        return $this;
    }

    /**
     * Get internet
     *
     * @return bool
     */
    public function getInternet()
    {
        return $this->internet;
    }

    /**
     * Set wifi
     *
     * @param boolean $wifi
     *
     * @return Hostel
     */
    public function setWifi($wifi)
    {
        $this->wifi = $wifi;

        return $this;
    }

    /**
     * Get wifi
     *
     * @return bool
     */
    public function getWifi()
    {
        return $this->wifi;
    }

    /**
     * @return mixed
     */
    public function getGuide()
    {
        return $this->guide;
    }

    /**
     * @param mixed $guide
     */
    public function setGuide($guide)
    {
        $this->guide = $guide;
    }

    /**
     * @return boolean
     */
    public function isHorseRide()
    {
        return $this->horseRide;
    }

    /**
     * @param boolean $horseRide
     */
    public function setHorseRide($horseRide)
    {
        $this->horseRide = $horseRide;
    }

    /**
     * @return boolean
     */
    public function isScubaDiving()
    {
        return $this->scubaDiving;
    }

    /**
     * @param boolean $scubaDiving
     */
    public function setScubaDiving($scubaDiving)
    {
        $this->scubaDiving = $scubaDiving;
    }

    /**
     * @return ArrayCollection
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
    public function isBreakfast()
    {
        return $this->breakfast;
    }

    /**
     * @param boolean $breakfast
     */
    public function setBreakfast($breakfast)
    {
        $this->breakfast = $breakfast;
    }

    /**
     * @return boolean
     */
    public function isDinner()
    {
        return $this->dinner;
    }

    /**
     * @param boolean $dinner
     */
    public function setDinner($dinner)
    {
        $this->dinner = $dinner;
    }

    /**
     * @return boolean
     */
    public function isCocktails()
    {
        return $this->cocktails;
    }

    /**
     * @param boolean $cocktails
     */
    public function setCocktails($cocktails)
    {
        $this->cocktails = $cocktails;
    }

    /**
     * @return boolean
     */
    public function isChildrenAccepted()
    {
        return $this->childrenAccepted;
    }

    /**
     * @param boolean $childrenAccepted
     */
    public function setChildrenAccepted($childrenAccepted)
    {
        $this->childrenAccepted = $childrenAccepted;
    }

    /**
     * @return boolean
     */
    public function isGarage()
    {
        return $this->garage;
    }

    /**
     * @param boolean $garage
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;
    }

    /**
     * @return string
     */
    public function getGaragePrice()
    {
        return $this->garagePrice;
    }

    /**
     * @param string $garagePrice
     */
    public function setGaragePrice($garagePrice)
    {
        $this->garagePrice = $garagePrice;
    }

    /**
     * @return boolean
     */
    public function isSwimmingPool()
    {
        return $this->swimmingPool;
    }

    /**
     * @param boolean $swimmingPool
     */
    public function setSwimmingPool($swimmingPool)
    {
        $this->swimmingPool = $swimmingPool;
    }

    /**
     * @return boolean
     */
    public function isLaundry()
    {
        return $this->laundry;
    }

    /**
     * @param boolean $laundry
     */
    public function setLaundry($laundry)
    {
        $this->laundry = $laundry;
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

    public function getCapacity() {
        $capacity = 0;
        foreach($this->getRooms() as $room) {
            $capacity += $room->getCapacity();
        }
        return $capacity;
    }

    public function getMinimumPrice() {
        $roomPrice = 0;
        foreach ($this->getRooms() as $room) {
            if($roomPrice == 0 || $room->getPriceInLow() < $roomPrice) {
                $roomPrice = $room->getPriceinLow();
            }
        }
        return $roomPrice;
    }
    
    public function __toString() {
        return $this->hostelName;
    }
}


