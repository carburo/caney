<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * OtherServices
 *
 * @ORM\Table(name="service_by_hostel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceByHostelRepository")
 */
class ServiceByHostel
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
     * @var Hostel
     * @ORM\ManyToOne(targetEntity="Hostel", inversedBy="services")
     * @ORM\JoinColumn(name="hostel_id", referencedColumnName="id")
     */
    private $hostel;

    /**
     * @var Service
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Hostel
     */
    public function getHostel(): Hostel
    {
        return $this->hostel;
    }

    /**
     * @param Hostel $hostel
     */
    public function setHostel(Hostel $hostel)
    {
        $this->hostel = $hostel;
    }

    /**
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service;
    }

    /**
     * @param Service $service
     */
    public function setService(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price)
    {
        $this->price = $price;
    }
}

