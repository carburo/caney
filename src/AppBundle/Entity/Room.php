<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoomRepository")
 */
class Room
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true, length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="integer")
     */
    private $capacity;

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
     * @var bool
     *
     * @ORM\Column(name="private_bathroom", type="boolean")
     */
    private $privateBathroom;

    /**
     * @var bool
     *
     * @ORM\Column(name="hot_water", type="boolean")
     */
    private $hotWater;

    /**
     * @var bool
     *
     * @ORM\Column(name="air_conditioner", type="boolean")
     */
    private $airConditioner;

    /**
     * @var bool
     *
     * @ORM\Column(name="voltage_120", type="boolean")
     */
    private $voltage120;

    /**
     * @var bool
     *
     * @ORM\Column(name="voltage_240", type="boolean")
     */
    private $voltage240;

    /**
     * @var bool
     *
     * @ORM\Column(name="private_entrance", type="boolean")
     */
    private $privateEntrance;

    /**
     * @var bool
     *
     * @ORM\Column(name="safe", type="boolean")
     */
    private $safe;

    /**
     * @var bool
     *
     * @ORM\Column(name="terrace", type="boolean")
     */
    private $terrace;

    /**
     * @var bool
     *
     * @ORM\Column(name="minibar", type="boolean")
     */
    private $minibar;

    /**
     * @var bool
     *
     * @ORM\Column(name="hair_dryer", type="boolean")
     */
    private $hairDryer;

    /**
     * @var bool
     *
     * @ORM\Column(name="television", type="boolean")
     */
    private $television;

    /**
     * @var string
     *
     * @ORM\Column(name="room_type", type="string", length=63)
     */
    private $type;

    /**
     * @var Hostel
     * @ORM\ManyToOne(targetEntity="Hostel", inversedBy="rooms")
     * @ORM\JoinColumn(name="hostel_id", referencedColumnName="id")
     */
    private $hostel;

    /**
     * @ORM\OneToMany(targetEntity="HostelImage", mappedBy="room")
     */
    private $images;


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
     * Set name
     *
     * @param string $name
     *
     * @return Room
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
     * Set description
     *
     * @param string $description
     *
     * @return Room
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Hostel
     */
    public function getHostel()
    {
        return $this->hostel;
    }

    /**
     * @param Hostel $hostel
     */
    public function setHostel($hostel)
    {
        $this->hostel = $hostel;
    }

    /**
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return string
     */
    public function getPriceInHigh()
    {
        return $this->priceInHigh;
    }

    /**
     * @param string $priceInHigh
     */
    public function setPriceInHigh($priceInHigh)
    {
        $this->priceInHigh = $priceInHigh;
    }

    /**
     * @return string
     */
    public function getPriceInLow()
    {
        return $this->priceInLow;
    }

    /**
     * @param string $priceInLow
     */
    public function setPriceInLow($priceInLow)
    {
        $this->priceInLow = $priceInLow;
    }

    /**
     * @return boolean
     */
    public function isPrivateBathroom()
    {
        return $this->privateBathroom;
    }

    /**
     * @param boolean $privateBathroom
     */
    public function setPrivateBathroom($privateBathroom)
    {
        $this->privateBathroom = $privateBathroom;
    }

    /**
     * @return boolean
     */
    public function isHotWater()
    {
        return $this->hotWater;
    }

    /**
     * @param boolean $hotWater
     */
    public function setHotWater($hotWater)
    {
        $this->hotWater = $hotWater;
    }

    /**
     * @return boolean
     */
    public function isAirConditioner()
    {
        return $this->airConditioner;
    }

    /**
     * @param boolean $airConditioner
     */
    public function setAirConditioner($airConditioner)
    {
        $this->airConditioner = $airConditioner;
    }

    /**
     * @return boolean
     */
    public function isVoltage120()
    {
        return $this->voltage120;
    }

    /**
     * @param boolean $voltage120
     */
    public function setVoltage120($voltage120)
    {
        $this->voltage120 = $voltage120;
    }

    /**
     * @return boolean
     */
    public function isVoltage240()
    {
        return $this->voltage240;
    }

    /**
     * @param boolean $voltage240
     */
    public function setVoltage240($voltage240)
    {
        $this->voltage240 = $voltage240;
    }

    public function getVoltage() {
        $voltage = array();
        if($this->isVoltage120()) {
            $voltage[] = 120;
        }
        if($this->isVoltage240()) {
            $voltage[] = 240;
        }
        return $voltage;
    }

    /**
     * @return boolean
     */
    public function isPrivateEntrance()
    {
        return $this->privateEntrance;
    }

    /**
     * @param boolean $privateEntrance
     */
    public function setPrivateEntrance($privateEntrance)
    {
        $this->privateEntrance = $privateEntrance;
    }

    /**
     * @return boolean
     */
    public function isSafe()
    {
        return $this->safe;
    }

    /**
     * @param boolean $safe
     */
    public function setSafe($safe)
    {
        $this->safe = $safe;
    }

    /**
     * @return boolean
     */
    public function isTerrace()
    {
        return $this->terrace;
    }

    /**
     * @param boolean $terrace
     */
    public function setTerrace($terrace)
    {
        $this->terrace = $terrace;
    }

    /**
     * @return boolean
     */
    public function isMinibar()
    {
        return $this->minibar;
    }

    /**
     * @param boolean $minibar
     */
    public function setMinibar($minibar)
    {
        $this->minibar = $minibar;
    }

    /**
     * @return boolean
     */
    public function isHairDryer()
    {
        return $this->hairDryer;
    }

    /**
     * @param boolean $hairDryer
     */
    public function setHairDryer($hairDryer)
    {
        $this->hairDryer = $hairDryer;
    }

    /**
     * @return boolean
     */
    public function isTelevision()
    {
        return $this->television;
    }

    /**
     * @param boolean $television
     */
    public function setTelevision($television)
    {
        $this->television = $television;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    public function __toString() {
        return "{$this->getHostel()->getHostelName()}: {$this->getName()}";
    }
}

