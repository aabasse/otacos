<?php

namespace EntrepriseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise")
 * @ORM\Entity(repositoryClass="EntrepriseBundle\Repository\EntrepriseRepository")
 */
class Entreprise
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    /**
   * @ORM\OneToMany(targetEntity="UtilisateurBundle\Entity\Utilisateur", mappedBy="entreprise")
   * @ORM\JoinColumn(nullable=true)
   */
    private $utilisateurs;

    /**
     * @var boolean
     *
     * @ORM\Column(name="est_abonne", type="boolean")
     */
    private $estAbonne = false;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Entreprise
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Entreprise
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    public function __toString()
    {
        return ucfirst($this->nom);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add utilisateur
     *
     * @param \UtilisateurBundle\Entity\Utilisateur $utilisateur
     *
     * @return Entreprise
     */
    public function addUtilisateur(\UtilisateurBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur
     *
     * @param \UtilisateurBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\UtilisateurBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs->removeElement($utilisateur);
    }

    /**
     * Get utilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }

    /**
     * Set estAbonne
     *
     * @param boolean $estAbonne
     *
     * @return Entreprise
     */
    public function setEstAbonne($estAbonne)
    {
        $this->estAbonne = $estAbonne;

        return $this;
    }

    /**
     * Get estAbonne
     *
     * @return boolean
     */
    public function getEstAbonne()
    {
        return $this->estAbonne;
    }
}
