<?php

namespace TracabiliteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="TracabiliteBundle\Repository\CategorieRepository")
 */
class Categorie
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
     * @Gedmo\Slug(fields={"libelle"})
     * @ORM\Column(length=60, unique=true)
     */
    private $slug;

    /**
   * @ORM\ManyToOne(targetEntity="TracabiliteBundle\Entity\Categorie")
   * @ORM\JoinColumn(nullable=true)
   */
    private $categoriePere;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * @return Categorie
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
     * Set image
     *
     * @param string $image
     *
     * @return Categorie
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Categorie
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set categoriePere
     *
     * @param \TracabiliteBundle\Entity\Categorie $categoriePere
     *
     * @return Categorie
     */
    public function setCategoriePere(\TracabiliteBundle\Entity\Categorie $categoriePere = null)
    {
        $this->categoriePere = $categoriePere;

        return $this;
    }

    /**
     * Get categoriePere
     *
     * @return \TracabiliteBundle\Entity\Categorie
     */
    public function getCategoriePere()
    {
        return $this->categoriePere;
    }

    public function __toString()
    {
        return ucfirst($this->libelle);
    }
}
