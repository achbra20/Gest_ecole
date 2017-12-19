<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table(name="classe")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ClasseRepository")
 */
class Classe
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
     * @ORM\Column(name="libelle", type="string", length=10)
     */
    private $libelle;
    /**
     *@ORM\ManyToOne(targetEntity="AdminBundle\Entity\Niveau", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Niveau;

    /**
     *@ORM\ManyToOne(targetEntity="AdminBundle\Entity\Annee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Annee;

    /**
     * @var ArrayCollection $eleve
     *
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\Eleve", mappedBy="Classe", cascade={"persist"})
     * @ORM\JoinTable(name="classe_eleve")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $Eleve;
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
     * @return Classe
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
     * Set niveau
     *
     * @param \AdminBundle\Entity\Niveau $niveau
     *
     * @return Classe
     */
    public function setNiveau(\AdminBundle\Entity\Niveau $niveau)
    {
        $this->Niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return \AdminBundle\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->Niveau;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Eleve = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set annee
     *
     * @param \AdminBundle\Entity\Annee $annee
     *
     * @return Classe
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

    /**
     * Add eleve
     *
     * @param \AdminBundle\Entity\eleve $eleve
     *
     * @return Classe
     */
    public function addEleve(\AdminBundle\Entity\eleve $eleve)
    {
        $this->Eleve[] = $eleve;

        return $this;
    }

    /**
     * Remove eleve
     *
     * @param \AdminBundle\Entity\eleve $eleve
     */
    public function removeEleve(\AdminBundle\Entity\eleve $eleve)
    {
        $this->Eleve->removeElement($eleve);
    }

    /**
     * Get eleve
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEleve()
    {
        return $this->Eleve;
    }
}
