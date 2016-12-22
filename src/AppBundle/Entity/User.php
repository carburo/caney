<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="profilePicture", type="string", length=255, nullable=true)
     */
    protected $profilePicture;
    
    /**
     * @Vich\UploadableField(mapping="user_profile_picture", fileNameProperty="profilePicture")
     * @var UploadedFile
     * @Assert\Image(
     * maxSize = "2048k"
     * )
     */
    protected $imageFile;
    
    /**
     * @var date
     *
     * @ORM\Column(name="updatedAt", type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="forename", type="string", length=255)
     * @Assert\NotBlank(message="Please enter your firstname.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     max=255,
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $forename;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     * @Assert\NotBlank(message="Please enter your surname.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     max=255,
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", nullable=true, length=255)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", nullable=true, length=2)
     */
    private $country;

    /**
     * @var bool
     *
     * @ORM\Column(name="owner", type="boolean", nullable=true)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="preferred_locale", type="string", length=10)
     */
    private $preferredLocale = 'en';

    /**
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * @param string $forename
     */
    public function setForename($forename)
    {
        $this->forename = $forename;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surename
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return "{$this->getForename()} {$this->getSurname()}";
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return boolean
     */
    public function isOwner()
    {
        return $this->owner;
    }

    /**
     * @param boolean $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getPreferredLocale(): string
    {
        return $this->preferredLocale;
    }

    /**
     * @param string $preferredLocale
     */
    public function setPreferredLocale(string $preferredLocale)
    {
        $this->preferredLocale = $preferredLocale;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
        
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

