<?php

namespace AdminBundle\Repository;

/**
 * PayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PayerRepository extends \Doctrine\ORM\EntityRepository
{
    // tourve les paiement effectuer par un eleve
    public function findPaiementByEleve($id)
    {
        $qb= $this->_em->createQueryBuilder();
        $qb-> select('a')
            ->from('AdminBundle:Payer','a')
            ->leftJoin('a.Eleve', 'e')
            ->Where('e.id = :id')
            ->setParameter('id',$id )
            ->addGroupBy('a.Annee');
        return $qb->getQuery()->getResult();

    }
    // les paiment d'un annee scolaire selon id
    public function findPaiementdeAnnee($id)
    {
        $qb= $this->_em->createQueryBuilder();
        $qb-> select('a')
            ->from('AdminBundle:Payer','a')
        ->leftJoin('a.Annee', 'ann')
            ->Where('ann.id = :id')
            ->setParameter('id',$id );
        return $qb->getQuery()->getResult();

    }

}