<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Films
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\FilmsRepository")
 */
class Films
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
     * @ORM\Column(name="titre", type="string", length=100)
     */
    private $titre;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention champs vide")
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datederealisation", type="date")
     */
    private $datederealisation;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention champs vide")
     * @ORM\Column(name="note", type="decimal")
     */
    private $note;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention champs vide")
     * @ORM\Column(name="image", type="string", length=100)
     */
    private $image;
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Genre")   #genere une multi liason avec films
     */
    private $liaisonGenre;


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
     * Set titre
     *
     * @param string $titre
     * @return Films
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Films
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datederealisation
     *
     * @param \DateTime $datederealisation
     * @return Films
     */
    public function setDatederealisation($datederealisation)
    {
        $this->datederealisation = $datederealisation;

        return $this;
    }

    /**
     * Get datederealisation
     *
     * @return \DateTime 
     */
    public function getDatederealisation()
    {
        return $this->datederealisation;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Films
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Films
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
    public function displayImageFilms()
    {
        return "images/films/".$this->image;
    }

    /**
     * Set liaisonGenre
     *
     * @param \Troiswa\BackBundle\Entity\Genre $liaisonGenre
     * @return Films
     */
    public function setLiaisonGenre(\Troiswa\BackBundle\Entity\Genre $liaisonGenre = null)
    {
        $this->liaisonGenre = $liaisonGenre;

        return $this;
    }

    /**
     * Get liaisonGenre
     *
     * @return \Troiswa\BackBundle\Entity\Genre 
     */
    public function getLiaisonGenre()
    {
        return $this->liaisonGenre;
    }

    private $fichier;

    public function getFichier()
    {
        return $this->fichier;

    }

    public function setFichier($fichier)
    {

        $this->fichier=$fichier;
        return $this;
    }

    public function upload()
    {
        if(null===$this->fichier)
        {
            return;
        }
        //$nameImage = $this->fichier->getClientOriginalName();
        $nameImage=uniqid()."-".$this->fichier->getClientOriginalName();

        $this->fichier->move(
            __DIR__.'/../../../../web/images/films',
            $nameImage
        );

        $this->image = $nameImage;

        $this->fichier = null;
    }
}
