<?php

namespace AdminBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * Eleve
 *
 * @ORM\Table(name="eleve")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\EleveRepository")
 */
class Eleve
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_pere", type="string", length=30)
     */
    private $nomPere;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_mere", type="string", length=30)
     */
    private $nomMere;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction_pere", type="string", length=20)
     */
    private $fonctionPere;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction_mere", type="string", length=30, nullable=true)
     */
    private $fonctionMere;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_parent1", type="string", length=30)
     */
    private $telParent1;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_parent2", type="string", length=30, nullable=true)
     */
    private $telParent2;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_naisance", type="string", length=10)
     */
    private $lieuNaisance;

    /**
     * @var string
     *
     * @ORM\Column(name="arrivede", type="string", length=10, nullable=true)
     */
    private $arrivede;

    /**
     * @var string
     *
     * @ORM\Column(name="niv_prec", type="string", length=10)
     */
    private $nivPrec;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_nais", type="date" , nullable=true)
     */
    private $dateNais;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=50)
     */
    private $adress;

    /**
     * @var int
     *
     * @ORM\Column(name="codePostal", type="integer")
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=30)
     */
    private $ville;
    /**
     * @var string
     *
     * @ORM\Column(name="adress_parent", type="string", length=30, nullable=true)
     */
    private $adress_parent;
    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=6)
     */
    private $sexe;
    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer", nullable=true)
     */
    private $tel;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateentre", type="date")
     */
    private $dateentre;
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255 ,nullable=true)
     */
    private $url;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $Classe
     *
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\Classe", inversedBy="Eleve", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="classe_eleve")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $Classe;



    private $file;
    private $tempFilename;
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
     * Set nomPere
     *
     * @param string $nomPere
     *
     * @return Eleve
     */
    public function setNomPere($nomPere)
    {
        $this->nomPere = $nomPere;

        return $this;
    }
    /**
     * Get nomPere
     *
     * @return string
     */
    public function getNomPere()
    {
        return $this->nomPere;
    }
    /**
     * Set nomMere
     *
     * @param string $nomMere
     *
     * @return Eleve
     */
    public function setNomMere($nomMere)
    {
        $this->nomMere = $nomMere;

        return $this;
    }
    /**
     * Get nomMere
     *
     * @return string
     */
    public function getNomMere()
    {
        return $this->nomMere;
    }

    /**
     * Set fonctionPere
     *
     * @param string $fonctionPere
     *
     * @return Eleve
     */
    public function setFonctionPere($fonctionPere)
    {
        $this->fonctionPere = $fonctionPere;

        return $this;
    }

    /**
     * Get fonctionPere
     *
     * @return string
     */
    public function getFonctionPere()
    {
        return $this->fonctionPere;
    }

    /**
     * Set fonctionMere
     *
     * @param string $fonctionMere
     *
     * @return Eleve
     */
    public function setFonctionMere($fonctionMere)
    {
        $this->fonctionMere = $fonctionMere;

        return $this;
    }

    /**
     * Get fonctionMere
     *
     * @return string
     */
    public function getFonctionMere()
    {
        return $this->fonctionMere;
    }

    /**
     * Set telParent1
     *
     * @param string $telParent1
     *
     * @return Eleve
     */
    public function setTelParent1($telParent1)
    {
        $this->telParent1 = $telParent1;

        return $this;
    }

    /**
     * Get telParent1
     *
     * @return string
     */
    public function getTelParent1()
    {
        return $this->telParent1;
    }

    /**
     * Set telParent2
     *
     * @param string $telParent2
     *
     * @return Eleve
     */
    public function setTelParent2($telParent2)
    {
        $this->telParent2 = $telParent2;

        return $this;
    }

    /**
     * Get telParent2
     *
     * @return string
     */
    public function getTelParent2()
    {
        return $this->telParent2;
    }

    /**
     * Set lieuNaisance
     *
     * @param \DateTime $lieuNaisance
     *
     * @return Eleve
     */
    public function setLieuNaisance($lieuNaisance)
    {
        $this->lieuNaisance = $lieuNaisance;

        return $this;
    }

    /**
     * Get lieuNaisance
     *
     * @return \DateTime
     */
    public function getLieuNaisance()
    {
        return $this->lieuNaisance;
    }

    /**
     * Set nbFrere
     *
     * @param integer $nbFrere
     *
     * @return Eleve
     */
    public function setNbFrere($nbFrere)
    {
        $this->nbFrere = $nbFrere;

        return $this;
    }

    /**
     * Get nbFrere
     *
     * @return int
     */
    public function getNbFrere()
    {
        return $this->nbFrere;
    }

    /**
     * Set nivPrec
     *
     * @param string $nivPrec
     *
     * @return Eleve
     */
    public function setNivPrec($nivPrec)
    {
        $this->nivPrec = $nivPrec;

        return $this;
    }

    /**
     * Get nivPrec
     *
     * @return string
     */
    public function getNivPrec()
    {
        return $this->nivPrec;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Eleve
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Eleve
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNais
     *
     * @param \DateTime $dateNais
     *
     * @return Eleve
     */
    public function setDateNais($dateNais)
    {
        $this->dateNais = $dateNais;

        return $this;
    }

    /**
     * Get dateNais
     *
     * @return \DateTime
     */
    public function getDateNais()
    {
        return $this->dateNais;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Eleve
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Eleve
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return integer
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Eleve
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return Eleve
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set adressParent
     *
     * @param string $adressParent
     *
     * @return Eleve
     */
    public function setAdressParent($adressParent)
    {
        $this->adress_parent = $adressParent;

        return $this;
    }

    /**
     * Get adressParent
     *
     * @return string
     */
    public function getAdressParent()
    {
        return $this->adress_parent;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Eleve
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateentre
     *
     * @param \DateTime $dateentre
     *
     * @return Eleve
     */
    public function setDateentre($dateentre)
    {
        $this->dateentre = $dateentre;

        return $this;
    }

    /**
     * Get dateentre
     *
     * @return \DateTime
     */
    public function getDateentre()
    {
        return $this->dateentre;
    }

    /**
     * Set arrivede
     *
     * @param string $arrivede
     *
     * @return Eleve
     */
    public function setArrivede($arrivede)
    {
        $this->arrivede = $arrivede;

        return $this;
    }

    /**
     * Get arrivede
     *
     * @return string
     */
    public function getArrivede()
    {
        return $this->arrivede;
    }
    /**
     * Set url
     *
     * @param string $url
     *
     * @return Eleve
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getFile()
    {
        return $this->file;
    }



    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->url) {
            $this->tempFilename = $this->url;

            $this->url = null;
        }

    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }
        $this->url = $this->file->guessExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this-> getUploadDir(),
            $this->id.'.'.$this->url
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        return 'upload/image/eleve';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Classe = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add classe
     *
     * @param \AdminBundle\Entity\Classe $classe
     *
     * @return Eleve
     */
    public function addClasse(\AdminBundle\Entity\Classe $classe)
    {
        $this->Classe[] = $classe;

        return $this;
    }

    /**
     * Remove classe
     *
     * @param \AdminBundle\Entity\Classe $classe
     */
    public function removeClasse(\AdminBundle\Entity\Classe $classe)
    {
        $this->Classe->removeElement($classe);
    }
    /**
     * Get classe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClasse()
    {
        return $this->Classe;
    }
}
