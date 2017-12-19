<?php

namespace AdminBundle\Repository;

/**
 * AnneeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnneeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAnneeActuelle()
    {
        $qb= $this->_em->createQueryBuilder();
        $qb-> select('a')
            ->from('AdminBundle:Annee','a')
            ->Where('a.dateFin > :date')
            ->setParameter('date',new \DateTime('now'));
        return $qb->getQuery()->getResult();

    }
}