<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * HostelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HostelRepository extends EntityRepository
{
    public function search($searchTerm) {
        $em = $this->getEntityManager();
        $mapping = new ResultSetMappingBuilder($em);
        $mapping->addRootEntityFromClassMetadata('AppBundle\Entity\Hostel', 'h');

        $sql = "CALL search_hostels(?)";
        $query = $em->createNativeQuery($sql, $mapping);
        $query->setParameter(1, $searchTerm);

        return $query->getResult();
    }

    public function searchPrefetch() {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "CALL search_prefetch()";
        $rawResult = array_values($conn->fetchAll($sql));
        $result = [];
        foreach ($rawResult as $value)
        {
            $result[] = $value["text"];
        }

        return $result;
    }

    public function activeByLocation($slug) {
        $em = $this->getEntityManager();
        $mapping = new ResultSetMappingBuilder($em);
        $mapping->addRootEntityFromClassMetadata('AppBundle\Entity\Hostel', 'h');

        $sql = "CALL active_hostels_by_location(?)";
        $query = $em->createNativeQuery($sql, $mapping);
        $query->setParameter(1, $slug);

        return $query->getResult();
    }
}
