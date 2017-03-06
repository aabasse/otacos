<?php

namespace ReceptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reception
 *
 * @ORM\Table(name="reception")
 * @ORM\Entity(repositoryClass="ReceptionBundle\Repository\ReceptionRepository")
 */
class Reception
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
   * @ORM\ManyToOne(targetEntity="TracabiliteBundle\Entity\Categorie")
   * @ORM\JoinColumn(nullable=false)
   */
    private $categorie;

    /**
   * @ORM\ManyToOne(targetEntity="EntrepriseBundle\Entity\Entreprise")
   * @ORM\JoinColumn(nullable=false)
   */
    private $entreprise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="degre", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern = "/^\d+([,|.]\d{1,2})?$/")
     */
    private $degre;

    /**
   * @ORM\OneToMany(targetEntity="TracabiliteBundle\Entity\Photo", mappedBy="reception", cascade={"persist", "remove"})
   * @ORM\JoinColumn(nullable=true)
    * @Assert\Count(
    *      min = 1,
    *      max = 3,
    *      minMessage = "Au moin une photo est nécessaire.",
    *      maxMessage = "Vous ne pouvez pas envoyer plus de {{ limit }} photos."
    * )
   * @Assert\Valid()
   */
    private $photos;

    /**
     * @var string
     *
     * @ORM\Column(name="bonLivraison", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $bonLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reception
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set degre
     *
     * @param string $degre
     *
     * @return Reception
     */
    public function setDegre($degre)
    {
        $this->degre = $degre;

        return $this;
    }

    /**
     * Get degre
     *
     * @return string
     */
    public function getDegre()
    {
        return $this->degre;
    }

    /**
     * Set bonLivraison
     *
     * @param string $bonLivraison
     *
     * @return Reception
     */
    public function setBonLivraison($bonLivraison)
    {
        $this->bonLivraison = $bonLivraison;

        return $this;
    }

    /**
     * Get bonLivraison
     *
     * @return string
     */
    public function getBonLivraison()
    {
        return $this->bonLivraison;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     *
     * @return Reception
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string
     */
    public function getRemarque()
    {
        return $this->remarque;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set categorie
     *
     * @param \TracabiliteBundle\Entity\Categorie $categorie
     *
     * @return Reception
     */
    public function setCategorie(\TracabiliteBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \TracabiliteBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add photo
     *
     * @param \TracabiliteBundle\Entity\Photo $photo
     *
     * @return Reception
     */
    public function addPhoto(\TracabiliteBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;
        $photo->setReception($this);
        return $this;
    }

    /**
     * Remove photo
     *
     * @param \TracabiliteBundle\Entity\Photo $photo
     */
    public function removePhoto(\TracabiliteBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set entreprise
     *
     * @param \EntrepriseBundle\Entity\Entreprise $entreprise
     *
     * @return Reception
     */
    public function setEntreprise(\EntrepriseBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \EntrepriseBundle\Entity\Entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }
}
