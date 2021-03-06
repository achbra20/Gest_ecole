<?php

namespace AdminBundle\Repository;


/**
 * paiementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class paiementRepository extends \Doctrine\ORM\EntityRepository
{
    public function touverNiveau($id)
    {
        $qb= $this->_em->createQueryBuilder();
        $qb-> select('a')
            ->from('AdminBundle:paiment','a')
            ->leftJoin('a.Niveau', 'n')
            ->Where('n.id = :id')
            ->setParameter('id',$id );
        return $qb->getQuery()->getResult();

    }

}
