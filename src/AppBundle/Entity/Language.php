<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Intl;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="iso_code", type="string", length=2)
     */
    private $isoCode;

    /**
     * Set isoCode
     *
     * @param string $isoCode
     *
     * @return Language
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    public function __toString()
    {
        return Intl::getLanguageBundle()->getLanguageName($this->getIsoCode());
    }
}

