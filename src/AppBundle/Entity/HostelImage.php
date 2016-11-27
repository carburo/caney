<?php

namespace AppBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * HostelImage
 *
 * @ORM\Table(name="hostel_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HostelImageRepository")
 * @Vich\Uploadable
 */
class HostelImage extends Image
{
    /**
     * @var Hostel
     * @ORM\ManyToOne(targetEntity="Hostel", inversedBy="images")
     * @ORM\JoinColumn(name="hostel_id", referencedColumnName="id")
     */
    private $hostel;

    /**
     * @var Room
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="images")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     */
    private $room;

    /**
     * @var PartOfTheHouse
     * @ORM\ManyToOne(targetEntity="PartOfTheHouse")
     * @ORM\JoinColumn(name="part_of_the_house_id", referencedColumnName="id")
     */
    private $partOfTheHouse;

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
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
        $this->setHostel($room->getHostel());
    }

    /**
     * @return PartOfTheHouse
     */
    public function getPartOfTheHouse()
    {
        return $this->partOfTheHouse;
    }

    /**
     * @param PartOfTheHouse $partOfTheHouse
     */
    public function setPartOfTheHouse($partOfTheHouse)
    {
        $this->partOfTheHouse = $partOfTheHouse;
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

    public function __toString() {
        return "{$this->hostel->getHostelName()}/{$this->getFilename()}";
    }
}

