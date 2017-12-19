<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payer
 *
 * @ORM\Table(name="payer")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\PayerRepository")
 */
class Payer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_payer", type="date")
     */
    private $datePayer;

    /**
     *@ORM\ManyToOne(targetEntity="AdminBundle\Entity\paiement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Paiment;
    /**
     *@ORM\ManyToOne(targetEntity="AdminBundle\Entity\Eleve")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Eleve;
    /**
     *@ORM\ManyToOne(targetEntity="AdminBundle\Entity\Annee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Annee;
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
     * Set montant
     *
     * @param float $montant
     *
     * @return Payer
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set datePayer
     *
     * @param \DateTime $datePayer
     *
     * @return Payer
     */
    public function setDatePayer($datePayer)
    {
        $this->datePayer = $datePayer;

        return $this;
    }

    /**
     * Get datePayer
     *
     * @return \DateTime
     */
    public function getDatePayer()
    {
        return $this->datePayer;
    }

    /**
     * Set paiment
     *
     * @param \AdminBundle\Entity\paiement $paiment
     *
     * @return Payer
     */
    public function setPaiment(\AdminBundle\Entity\paiement $paiment)
    {
        $this->Paiment = $paiment;

        return $this;
    }

    /**
     * Get paiment
     *
     * @return \AdminBundle\Entity\paiement
     */
    public function getPaiment()
    {
        return $this->Paiment;
    }

    /**
     * Set eleve
     *
     * @param \AdminBundle\Entity\Eleve $eleve
     *
     * @return Payer
     */
    public function setEleve(\AdminBundle\Entity\Eleve $eleve)
    {
        $this->Eleve = $eleve;

        return $this;
    }

    /**
     * Get eleve
     *
     * @return \AdminBundle\Entity\Eleve
     */
    public function getEleve()
    {
        return $this->Eleve;
    }

    /**
     * Set annee
     *
     * @param \AdminBundle\Entity\Annee $annee
     *
     * @return Payer
     */
    public function setAnnee(\AdminBundle\Entity\Annee $annee)
    {
        $this->Annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return \AdminBundle\Entity\Annee
     */
    public function getAnnee()
    {
        return $this->Annee;
    }
}
