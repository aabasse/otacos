<?php

namespace TemperatureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
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
}
