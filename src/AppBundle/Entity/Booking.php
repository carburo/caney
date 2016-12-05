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
     * @ORM\Column(name="booking_datetime", type="datetime")
     */
    private $bookingDatetime;

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
     * @var ContactThread
     * @ORM\OneToOne(targetEntity="ContactThread", cascade={"persist"})
     * @ORM\JoinColumn(name="thread_id", referencedColumnName="id")
     */
    private $commentThread;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private $status;

    public function __construct()
    {
        $this->bookingDatetime = new \DateTime();
        $this->status = "PENDING";
        $this->commentThread = new ContactThread();
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

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getBookingDatetime(): \DateTime
    {
        return $this->bookingDatetime;
    }

    /**
     * @param \DateTime $bookingDatetime
     */
    public function setBookingDatetime(\DateTime $bookingDatetime)
    {
        $this->bookingDatetime = $bookingDatetime;
    }

    /**
     * @return ContactThread
     */
    public function getCommentThread(): ContactThread
    {
        return $this->commentThread;
    }

    /**
     * @param ContactThread $commentThread
     */
    public function setCommentThread(ContactThread $commentThread)
    {
        $this->commentThread = $commentThread;
    }
}

