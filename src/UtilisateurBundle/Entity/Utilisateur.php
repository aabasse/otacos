<?php

namespace UtilisateurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UtilisateurBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser
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
   * @ORM\ManyToOne(targetEntity="EntrepriseBundle\Entity\Entreprise", inversedBy="utilisateurs")
   * @ORM\JoinColumn(nullable=true)
   */
    private $entreprise;

    private $lesRoles;


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
     * Set entreprise
     *
     * @param \EntrepriseBundle\Entity\Entreprise $entreprise
     *
     * @return Utilisateur
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

    public function setLesRoles($lesRoles)
    {
        $this->lesRoles = $lesRoles;

        return $this;
    }

    public function getLesRoles()
    {
        return $this->lesRoles;
    }


}
