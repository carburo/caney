<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Hostel;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * ServiceClassificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceClassificationRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByHostel(Hostel $hostel) {
        $em = $this->getEntityManager();
        $mapping = new ResultSetMappingBuilder($em);
        $mapping->addRootEntityFromClassMetadata('AppBundle\Entity\ServiceClassification', 's');

        $sql = "CALL service_classifications_by_hostel(?)";
        $query = $em->createNativeQuery($sql, $mapping);
        $query->setParameter(1, $hostel->getId());

        return $query->getResult();
    }

}
