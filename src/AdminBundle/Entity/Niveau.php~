<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table(name="niveau")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\NiveauRepository")
 */
class Niveau
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=20)
     */
    private $libelle;
    /**
     * @var float
     *
     * @ORM\Column(name="prixmois", type="float" ,nullable=true)
     */
    private $prixmois;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $paiment
     *
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\paiement",  inversedBy="Niveau", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="niveau_paiement")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $paiement;
    /**
     * One matiere has Many Coefficient.
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\Coefficient", mappedBy="niveau")
     * @ORM\JoinColumn(nullable=true)
     */
    private $coefficient;
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Niveau
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set prixmois
     *
     * @param float $prixmois
     *
     * @return Niveau
     */
    public function setPrixmois($prixmois)
    {
        $this->prixmois = $prixmois;

        return $this;
    }

    /**
     * Get prixmois
     *
     * @return float
     */
    public function getPrixmois()
    {
        return $this->prixmois;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paiement = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add paiement
     *
     * @param \AdminBundle\Entity\paiement $paiement
     *
     * @return Niveau
     */
    public function addPaiement(\AdminBundle\Entity\paiement $paiement)
    {
        $this->paiement[] = $paiement;

        return $this;
    }

    /**
     * Remove paiement
     *
     * @param \AdminBundle\Entity\paiement $paiement
     */
    public function removePaiement(\AdminBundle\Entity\paiement $paiement)
    {
        $this->paiement->removeElement($paiement);
    }

    /**
     * Get paiement
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaiement()
    {
        return $this->paiement;
    }

    /**
     * Add coefficient
     *
     * @param \AdminBundle\Entity\Coefficient $coefficient
     *
     * @return Niveau
     */
    public function addCoefficient(\AdminBundle\Entity\Coefficient $coefficient)
    {
        $this->coefficient[] = $coefficient;

        return $this;
    }

    /**
     * Remove coefficient
     *
     * @param \AdminBundle\Entity\Coefficient $coefficient
     */
    public function removeCoefficient(\AdminBundle\Entity\Coefficient $coefficient)
    {
        $this->coefficient->removeElement($coefficient);
    }

    /**
     * Get coefficient
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }
}
