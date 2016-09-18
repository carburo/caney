<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 7/05/16
 * Time: 23:31
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="province_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="province_lookup_unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class ProvinceTranslation extends AbstractPersonalTranslation {

    /**
     * Convenient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale = null, $field = null, $value = null)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }

    /**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

    public function __toString() {
        return $this->content;
    }
}