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
     * @var string
     *
     * @ORM\Column(name="room_type", type="string", length=63)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="double_beds_amount", type="integer")
     */
    private $doubleBedsAmount = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="single_beds_amount", type="integer")
     */
    private $singleBedsAmount = 0;

    /**
     * @var Hostel
     * @ORM\ManyToOne(targetEntity="Hostel", inversedBy="rooms")
     * @ORM\JoinColumn(name="hostel_id", referencedColumnName="id")
     */
    private $hostel;

    /**
     *
     * @ORM\ManyToMany(targetEntity="RoomService")
     * @ORM\JoinTable(name="service_by_room",
     *      joinColumns={@ORM\JoinColumn(name="room_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id")}
     *      )
     */
    private $services;

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
     * @return int
     */
    public function getDoubleBedsAmount(): int
    {
        return $this->doubleBedsAmount;
    }

    /**
     * @param int $doubleBedsAmount
     */
    public function setDoubleBedsAmount(int $doubleBedsAmount)
    {
        $this->doubleBedsAmount = $doubleBedsAmount;
    }

    /**
     * @return int
     */
    public function getSingleBedsAmount(): int
    {
        return $this->singleBedsAmount;
    }

    /**
     * @param int $singleBedsAmount
     */
    public function setSingleBedsAmount(int $singleBedsAmount)
    {
        $this->singleBedsAmount = $singleBedsAmount;
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

