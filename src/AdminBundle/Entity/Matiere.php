<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\MatiereRepository")
 */
class Matiere
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
     * One matiere has Many Coefficient.
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\Coefficient", mappedBy="matiere")
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
     * @return Matiere
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
     * Constructor
     */
    public function __construct()
    {
        $this->coefficient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add coefficient
     *
     * @param \AdminBundle\Entity\Coefficient $coefficient
     *
     * @return Matiere
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
