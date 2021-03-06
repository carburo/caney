<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * LocationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LocationRepository extends SortableRepository
{
    public function activeLocations() {
        $em = $this->getEntityManager();
        $mapping = new ResultSetMappingBuilder($em);
        $mapping->addRootEntityFromClassMetadata('AppBundle\Entity\Location', 'l');

        $sql = "CALL active_locations()";
        $query = $em->createNativeQuery($sql, $mapping);

        return $query->getResult();
    }

    public function activeHostelsCount($slug) {
        $em = $this->getEntityManager();
        $mapping = new ResultSetMappingBuilder($em);
        $mapping->addScalarResult('count', 'count', 'integer');

        $sql = "SELECT active_hostels_count_by_location(?) count";
        $query = $em->createNativeQuery($sql, $mapping);
        $query->setParameter(1, $slug);

        return $query->getResult()[0]["count"];
    }
}
