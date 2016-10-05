<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
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
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;

    /**
     * @var Hostel
     * @ORM\ManyToOne(targetEntity="Hostel")
     * @ORM\JoinColumn(name="hostel_id", referencedColumnName="id")
     */
    private $hostel;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Room
     *
     * @ORM\ManyToMany(targetEntity="Room")
     * @ORM\JoinTable(name="booked_rooms",
     *      joinColumns={@ORM\JoinColumn(name="booking_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="room_id", referencedColumnName="id")}
     *      )
     */
    private $rooms;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_persons", type="integer")
     */
    private $numberOfPersons;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", nullable=true, length=4000)
     */
    private $comments;


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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Booking
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Booking
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param Room $rooms
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
    }

    /**
     * @return int
     */
    public function getNumberOfPersons()
    {
        return $this->numberOfPersons;
    }

    /**
     * @param int $numberOfPersons
     */
    public function setNumberOfPersons($numberOfPersons)
    {
        $this->numberOfPersons = $numberOfPersons;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}

