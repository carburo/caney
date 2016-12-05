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
 * ContactThread
 *
 * @ORM\Table(name="contact_thread")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactThreadRepository")
 */
class ContactThread {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="ContactMessage", mappedBy="thread")
     */
    private $messages;

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
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }
}