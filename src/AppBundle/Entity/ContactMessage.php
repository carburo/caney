<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 14.04.16
 * Time: 16:51
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactMessage
 *
 * @ORM\Table(name="contact_message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactMessageRepository")
 */
class ContactMessage {

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
     * @ORM\Column(name="message_datetime", type="datetime")
     */
    private $messageDatetime;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", nullable=true, length=4000)
     */
    private $message;

    /**
     * @var ContactThread
     * @ORM\ManyToOne(targetEntity="ContactThread", inversedBy="messages")
     * @ORM\JoinColumn(name="thread_id", referencedColumnName="id")
     */
    private $thread;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime
     */
    public function getMessageDatetime(): \DateTime
    {
        return $this->messageDatetime;
    }

    /**
     * @param \DateTime $messageDatetime
     */
    public function setMessageDatetime(\DateTime $messageDatetime)
    {
        $this->messageDatetime = $messageDatetime;
    }

    /**
     * @return ContactMessage
     */
    public function getThread(): ContactMessage
    {
        return $this->thread;
    }

    /**
     * @param ContactMessage $thread
     */
    public function setThread(ContactMessage $thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}