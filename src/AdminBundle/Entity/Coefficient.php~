<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coefficient
 *
 * @ORM\Table(name="coefficient")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CoefficientRepository")
 */
class Coefficient
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
     * @ORM\Column(name="coefficient", type="float")
     */
    private $coefficient;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_heure", type="integer")
     */
    private $nbHeure;
    /**
     * Many coefficient have One matiere.
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Matiere", inversedBy="coefficient")
     * @ORM\JoinColumn(nullable=true)
     */
    private $matiere;

    /**
     * Many coefficient have One Niveau.
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Niveau", inversedBy="coefficient")
     * @ORM\JoinColumn(nullable=true)
     */
    private $niveau;
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
     * Set coefficient
     *
     * @param float $coefficient
     *
     * @return Coefficient
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return float
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set nbHeure
     *
     * @param integer $nbHeure
     *
     * @return Coefficient
     */
    public function setNbHeure($nbHeure)
    {
        $this->nbHeure = $nbHeure;

        return $this;
    }

    /**
     * Get nbHeure
     *
     * @return int
     */
    public function getNbHeure()
    {
        return $this->nbHeure;
    }

    /**
     * Set matiere
     *
     * @param \AdminBundle\Entity\Matiere $matiere
     *
     * @return Coefficient
     */
    public function setMatiere(\AdminBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \AdminBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set niveau
     *
     * @param \AdminBundle\Entity\Niveau $niveau
     *
     * @return Coefficient
     */
    public function setNiveau(\AdminBundle\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return \AdminBundle\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }
}
