<?php

namespace TemperatureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Releve
 *
 * @ORM\Table(name="releve")
 * @ORM\Entity(repositoryClass="TemperatureBundle\Repository\ReleveRepository")
 */
class Releve
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
    * @ORM\OneToMany(targetEntity="TemperatureBundle\Entity\Degre", mappedBy="releve", cascade={"persist"}, orphanRemoval=true)
    * @Assert\Count(
    *      min = 1,
    *      max = 40,
    *      minMessage = "Au moin une temperature est nécessaire.",
    *      maxMessage = "Vous ne pouvez pas envoyer plus de {{ limit }} temperature."
    * )
    * @Assert\Valid()
    */
    private $degres;

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
     * @ORM\Column(name="moment", type="string", length=255)
     */
    private $moment;


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
     * @return Releve
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
     * Set moment
     *
     * @param string $moment
     *
     * @return Releve
     */
    public function setMoment($moment)
    {
        $this->moment = $moment;

        return $this;
    }

    /**
     * Get moment
     *
     * @return string
     */
    public function getMoment()
    {
        return $this->moment;
    }

    /**
     * Set categorie
     *
     * @param \TracabiliteBundle\Entity\Categorie $categorie
     *
     * @return Releve
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
     * Constructor
     */
    public function __construct()
    {
        $this->degres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add degre
     *
     * @param \TemperatureBundle\Entity\Degre $degre
     *
     * @return Releve
     */
    public function addDegre(\TemperatureBundle\Entity\Degre $degre)
    {
        $this->degres[] = $degre;
        $degre->setReleve($this);
        return $this;
    }

    /**
     * Remove degre
     *
     * @param \TemperatureBundle\Entity\Degre $degre
     */
    public function removeDegre(\TemperatureBundle\Entity\Degre $degre)
    {
        $this->degres->removeElement($degre);
    }

    /**
     * Get degres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDegres()
    {
        return $this->degres;
    }

    public function getLesMoment(){
        return array( 'matin', 'soir');
    }

    /**
     * Set entreprise
     *
     * @param \EntrepriseBundle\Entity\Entreprise $entreprise
     *
     * @return Releve
     */
    public function setEntreprise(\EntrepriseBundle\Entity\Entreprise $entreprise)
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
