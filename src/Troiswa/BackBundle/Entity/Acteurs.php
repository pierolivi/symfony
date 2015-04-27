<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Acteurs
 *
 * @ORM\Table(name="acteur")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ActeursRepository")
 */
class Acteurs
{


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention champs vide")
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention champs vide")
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="boolean")
     */
    private $sexe;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention champs vide")
     * @ORM\Column(name="biographie", type="text")
     */
    private $biographie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datenaissance", type="date")
     */
    private $datenaissance;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention champs vide")
     * @ORM\Column(name="ville", type="string", length=100)
     */
    private $ville;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Acteurs
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
     * Set nom
     *
     * @param string $nom
     * @return Acteurs
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
     * Set biographie
     *
     * @param string $biographie
     * @return Acteurs
     */
    public function setBiographie($biographie)
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get biographie
     *
     * @return string
     */
    public function getBiographie()
    {
        return $this->biographie;
    }

    /**
     * Set datenaissance
     *
     * @param \DateTime $datenaissance
     * @return Acteurs
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return \DateTime
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Acteurs
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
     * Set image
     *
     * @param string $image
     * @return Acteurs
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return Acteurs
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    public function displayImageActeurs()
    {
        return "images/acteurs/" . $this->image;
    }

    /**
     * @Assert\Image(
     *     maxSize = "3M",
     *     maxSizeMessage = "fichier trop grand:(< 3 Mbytes)",
     *     mimeTypes = {"image/png", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Choisissez un fichier de type jpg, jpeg ou png"
     * )
     */
    private $fichier;

    public function getFichier()
    {
        return $this->fichier;

    }

    public function setFichier($fichier)
    {

        $this->fichier = $fichier;
        return $this;

    }
        public function upload()
        {
            if (null === $this->fichier)
            {
                return;
            }
            //$nameImage = $this->fichier->getClientOriginalName();
            $nameImage = uniqid() . "-" . $this->fichier->getClientOriginalName();

            $this->fichier->move(
                __DIR__ . '/../../../../web/images/acteurs',
                $nameImage
            );

            $this->image = $nameImage;

            $this->fichier = null;
        }

    /**
     *
     *
     * @ORM\ManyToMany(targetEntity="Troiswa\BackBundle\Entity\Films")
     *
     */
    private $liaisonFilms;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->liaisonFilms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add liaisonFilms
     *
     * @param \Troiswa\BackBundle\Entity\Films $liaisonFilms
     * @return Acteurs
     */
    public function addLiaisonFilm(\Troiswa\BackBundle\Entity\Films $liaisonFilms)
    {
        $this->liaisonFilms[] = $liaisonFilms;

        return $this;
    }

    /**
     * Remove liaisonFilms
     *
     * @param \Troiswa\BackBundle\Entity\Films $liaisonFilms
     */
    public function removeLiaisonFilm(\Troiswa\BackBundle\Entity\Films $liaisonFilms)
    {
        $this->liaisonFilms->removeElement($liaisonFilms);
    }

    /**
     * Get liaisonFilms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLiaisonFilms()
    {
        return $this->liaisonFilms;
    }
}
