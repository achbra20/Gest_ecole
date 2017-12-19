<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\paiementRepository")
 */
class paiement
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
     * @ORM\Column(name="libelle", type="string", length=150)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="nbmois", type="integer")
     */
    private $nbmois;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deb", type="date")
     */
    private $dateDeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date")
     */
    private $dateFin;
    /**
     * @var float
     *
     * @ORM\Column(name="remise", type="float")
     */
    private $remise;

    /**
     * @var ArrayCollection $Niveau
     *
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\Niveau", mappedBy="paiement", cascade={"persist"})
     * @ORM\JoinTable(name="niveau_paiement")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $Niveau;

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
     * @return paiement
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
     * Set nbmois
     *
     * @param integer $nbmois
     *
     * @return paiement
     */
    public function setNbmois($nbmois)
    {
        $this->nbmois = $nbmois;

        return $this;
    }

    /**
     * Get nbmois
     *
     * @return int
     */
    public function getNbmois()
    {
        return $this->nbmois;
    }

    /**
     * Set remise
     *
     * @param float $remise
     *
     * @return paiement
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return float
     */
    public function getRemise()
    {
        return $this->remise;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Niveau = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add niveau
     *
     * @param \AdminBundle\Entity\Niveau $niveau
     *
     * @return paiement
     */
    public function addNiveau(\AdminBundle\Entity\Niveau $niveau)
    {
        $this->Niveau[] = $niveau;

        return $this;
    }

    /**
     * Remove niveau
     *
     * @param \AdminBundle\Entity\Niveau $niveau
     */
    public function removeNiveau(\AdminBundle\Entity\Niveau $niveau)
    {
        $this->Niveau->removeElement($niveau);
    }

    /**
     * Get niveau
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNiveau()
    {
        return $this->Niveau;
    }

    /**
     * Set dateDeb
     *
     * @param \DateTime $dateDeb
     *
     * @return paiement
     */
    public function setDateDeb($dateDeb)
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    /**
     * Get dateDeb
     *
     * @return \DateTime
     */
    public function getDateDeb()
    {
        return $this->dateDeb;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return paiement
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
}
